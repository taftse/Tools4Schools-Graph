<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/09/2019
 * Time: 22:28
 */

namespace Tools4Schools\Graph\Language;

use http\Exception\UnexpectedValueException;
use Tools4Schools\Graph\Contracts\Language\Lexer as LexerContract;
use Tools4Schools\Graph\Contracts\Language\Parser as ParserContract;
use Tools4Schools\Graph\Language\AST\Argument;
use Tools4Schools\Graph\Language\AST\Document;
use Tools4Schools\Graph\Language\AST\FragmentDefinition;
use Tools4Schools\Graph\Language\AST\FragmentSpread;
use Tools4Schools\Graph\Language\AST\InlineFragment;
use Tools4Schools\Graph\Language\AST\Location;
use Tools4Schools\Graph\Language\AST\OperationDefinition;
use Tools4Schools\Graph\Language\AST\Field;
use Tools4Schools\Graph\Language\AST\Types\BooleanType;
use Tools4Schools\Graph\Language\AST\Types\EnumType;
use Tools4Schools\Graph\Language\AST\Types\IntType;
use Tools4Schools\Graph\Language\AST\Types\ListType;
use Tools4Schools\Graph\Language\AST\Types\NamedType;
use Tools4Schools\Graph\Language\AST\Types\NonNullType;
use Tools4Schools\Graph\Language\AST\Types\StringType;
use Tools4Schools\Graph\Language\AST\VariableDefinition;

class Parser implements ParserContract
{

    protected $lexer;

    public function __construct(LexerContract $lexer)
    {
        $this->lexer = $lexer;
    }

    public function parse($query) : Document
    {

        $this->lexer->read($query);
        $document = $this->parseDocument();


        return $document;
    }

    /**
     * Check if the current token type is of the the same type
     *
     * @param string $tokenType
     * @return bool
     */
    protected function isType(string $tokenType):bool
    {
        return $this->lexer->current()->type() === $tokenType;
    }

    /**
     * Check if the current token is of the expected type
     *
     * @param string $tokenType
     * @return Token
     * @throws \Exception
     */
    protected function expectedType(string $tokenType): Token
    {
        $token = $this->lexer->current();

        if($this->isType($tokenType))
        {
            $this->lexer->advance();
            return $token;
        }
        //dump($this->lexer);
        // throw error Expected TokenType but found current token type
        throw new \Exception('Expected '.$tokenType.' but found '.$token->type(). ' token no '.(count($this->lexer->tokens) -2 ) .' Character no '.$token->position());
    }

    /**
     * Check if the current token contians the expected value
     *
     * @param string $value
     * @return Token
     * @throws \Exception
     */
    protected function expectedValue(string $value): Token
    {
        $token = $this->lexer->current();

        if($this->isType(SupportedTokens::NAME) && $token->value() == $value )
        {
            $this->lexer->advance();
            return $token;
        }
        // throw error Expected TokenType but found current token type
        throw new \Exception('Expected token value'.$value.' but found '.$token->value(). ' token no '.$token->position());
    }

    public function skipType(string $tokenType):bool
    {
        if($this->isType($tokenType))
        {
            $this->lexer->advance();
            return true;
        }
        return false;
    }


    protected function parseDocument():Document
    {
        $document = New Document();

        // expect the first token to be a start of file
        $this->expectedType(SupportedTokens::SOF);


            // while the token is not equal to the end of file token
        do{
            $document->addDefinition($this->parseDefinition());
        }
        while($this->lexer->current()->type() != SupportedTokens::EOF);

        return $document;
    }

    protected function parseDefinition()
    {

        if ($this->isType(SupportedTokens::NAME)) {
            switch ($this->lexer->current()->value()) {
                case 'query':
                case 'mutation':
                case 'subscription':
                    return $this->parseOperationDefinition();
                    break;
                case 'fragment':
                    return $this->parseFragmentDefinition();
                    break;
            }
        }
        elseif ($this->isType( SupportedTokens::BRACE_L))
        {
            return $this->parseOperationDefinition();
        }

        throw new \UnexpectedValueException(
            'previous: '.$this->lexer->previous()->type().' '.$this->lexer->previous()->value().
            ' current: '.$this->lexer->current()->type().' '.$this->lexer->current()->value().
            ' next: '.$this->lexer->next()->type().' '.$this->lexer->next()->value()

        );
    }

     protected function parseOperationDefinition()
     {
         $start = $this->lexer->current();
         // is it a shorthand query ?
        if($this->isType(SupportedTokens::BRACE_L)){
            return new OperationDefinition(
                'query',
                '',
                [],
                $this->parseSelectionSet(),
                null,
                $this->location($start)
            );
        }

        // nope lets see what type of operation we are going to execute
        $operation = $this->parseOperationType();

        $name = '';
        if($this->isType(SupportedTokens::NAME))
        {
            $name = $this->parseName();
        }

        return new OperationDefinition(
            $operation,

            $name,
            $this->parseVariableDefinitions(),
            $this->parseSelectionSet(),// selection sets
            null,
            $this->location($start)

        );
     }

     protected function parseFragmentDefinition()
     {
         $start = $this->lexer->current();

         $this->expectedValue('fragment');

         $name = $this->parseName();

         $this->expectedValue('on');

         $typeCondition = $this->parseNamedType();

         return new FragmentDefinition(
             $name,
             $typeCondition,
             // $this->parseDirectives(),
             [],
             $this->parseSelectionSet(),
             $this->location($start)
         );
         throw new \Exception('NotImplementedException');
     }

     protected function parseOperationType()
     {
        $token = $this->expectedType(SupportedTokens::NAME);

        switch ($token->value())
        {
            case 'query':
            case 'mutation':
            case 'subscription':
                return $token->value();
                break;
            default:
                throw new UnexpectedValueException($token);
                break;
        }

     }

     protected function parseName()
     {
         return $this->expectedType(SupportedTokens::NAME)->value();
     }

     protected function parseVariableDefinitions():array
     {
         $arguments = [];
         // has the text got attributes
         if($this->isType(SupportedTokens::PAREN_L))
         {
             $this->lexer->advance();
             // while we dont have a closing bracket ) parse each of the variables
            while($this->lexer->current()->type() != SupportedTokens::PAREN_R)
            {
                $arguments[] = $this->parseVariableDefinition();
            }
            $this->lexer->advance();
         }
         return $arguments;
     }

     protected function parseSelectionSet()
     {
         $selections = [];
         if($this->expectedType(SupportedTokens::BRACE_L))
         {
             // while we dont have a closing brace } parse each of the variables
             do
             {
                 $selections[] = $this->parseSelection();
             }while($this->lexer->current()->type() != SupportedTokens::BRACE_R);
         }
         $this->lexer->advance();
         return $selections;

     }


     protected function parseSelection()
     {
         if ($this->isType(SupportedTokens::SPREAD))
         {
             return $this->parseFragment();
         }
         return $this->parseField();
     }

     protected function parseField()
     {
         $alias = null;
         $name = $this->parseName();

        if($this->skipType(SupportedTokens::COLON))
        {
            $alias = $name;
            $name = $this->parseName();
        }

        return new Field(
            $name,
            $alias,
            $this->parseArguments(),
            [],//$this->parseDirectives(),
            $this->isType(SupportedTokens::BRACE_L) ? $this->parseSelectionSet() : null
        );

     }

     protected function parseArguments()
     {
         $arguments = [];
         if($this->isType(SupportedTokens::PAREN_L))
         {
             // while we dont have a closing brace } parse each of the variables
             do
             {
                 $arguments[] = $this->parseArgument();
             }while($this->lexer->current()->type() != SupportedTokens::PAREN_R);
             $this->lexer->advance();
           //  dump($this->lexer);

         }
         return $arguments;
     }

     protected function parseArgument()
     {
         $this->lexer->advance();
         $name = $this->parseName();

         $this->expectedType(SupportedTokens::COLON);

         return new Argument(
             $name,
             $this->parseValue()
         );
     }


     protected function parseValue()
     {
        switch ($this->lexer->current()->type())
        {
            case SupportedTokens::BRACKET_L:
                return $this->parseArray();
            case SupportedTokens::BRACE_L:
                return $this->parseObject();
                // should I bundle Int And Floats ????
            case SupportedTokens::INT:
                return $this->parseInt();
            case SupportedTokens::FLOAT:
                return $this->parseFloat();
            case SupportedTokens::STRING:
            case SupportedTokens::BLOCK_STRING:
                return $this->parseString();
            case SupportedTokens::NAME:
                switch($this->lexer->current()->value())
                {
                    case 'true':
                    case 'false':
                        return $this->parseBoolean();
                    case 'null':
                        return null;
                    default:
                        return $this->parseEnum();
                }
            case SupportedTokens::DOLLAR:
                // if the value is not a constant
                return $this->parseVariable();

        }

        throw $this->unexpectedException();
     }

     protected function parseBoolean()
     {
         $start = $this->lexer->current();
         $this->lexer->advance();
         return new BooleanType($this->lexer->current()->value() === "true", $this->location($start));
     }

     protected function parseEnum()
     {
         $start = $this->lexer->current();
         $value = $start->value();
         $this->lexer->advance();
         return new EnumType($value,$this->location($start));
     }

     protected function parseString()
     {
         $start = $this->lexer->current();
         $value = $start->value();
         $this->lexer->advance();
         return new StringType($value,$this->location($start));
     }

     protected function parseFragment()
     {
         // check token is ... and move to the next token
         $this->expectedType(SupportedTokens::SPREAD);

         // if the token type is name and the value is not "on" return a fragment
         if($this->isType(SupportedTokens::NAME) && $this->lexer->current()->value() !== 'on')
         {
            return new FragmentSpread(
                $this->parseName(),
                //$this->parseDirectives()
            );
         }

         $typedCondition = null;
         if($this->lexer->current()->value() === 'on')
         {
            $this->lexer->advance();
            $typedCondition = $this->parseName(); // parseNamedType ?
         }


         return new InlineFragment(
             $typedCondition,
             //$this->parseDirectives(),
             [],
             $this->parseSelectionSet()
         );

     }

     protected function parseVariableDefinition()
     {
        $start = $this->lexer->current();

        $variable = $this->parseVariable();

        $this->expectedType(SupportedTokens::COLON);
        $type = $this->parseTypeReference();

        $default = null;
        if($this->isType(SupportedTokens::EQUALS))
        {
            $this->lexer->advance();
            $default = $this->parseValue();
        }

        return new VariableDefinition($variable,$type,$default,$this->location($start));
     }

     protected function parseVariable()
     {
        $this->expectedType(SupportedTokens::DOLLAR);
        return $this->parseName();
     }

     protected function parseInt()
     {
         $start = $this->lexer->current();
         $value = $start->value();
         $this->lexer->advance();
         return new IntType($value,$this->location($start));
     }

     protected function parseTypeReference()
     {
         $start = $this->lexer->current();

         if($this->isType(SupportedTokens::BRACKET_L))
         {
             $type = $this->parseTypeReference();
             $this->expectedType(SupportedTokens::BRACKET_L);
             $type = new ListType($type,$this->location($start));
         }else{
            $type = $this->parseNamedType();
         }

         if($this->isType(SupportedTokens::BANG))
         {
             $this->lexer->advance();
             return $type->required();//new NonNullType($type,$this->location($start));
         }
            return $type;
     }

     protected function parseNamedType()
     {
         $start = $this->lexer->current();
         return new NamedType($this->parseName(),$this->location($start));
     }

     protected function location(Token $startToken)
     {
        return new Location($startToken,$this->lexer->previous(),$this->lexer->text);
     }

     protected function unexpectedException()
     {
        dd($this->lexer->current());
     }
}
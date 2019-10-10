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
use Tools4Schools\Graph\Language\AST\Document;
use Tools4Schools\Graph\Language\AST\OperationDefinition;
use Tools4Schools\Graph\Language\AST\Field;

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
        // throw error Expected TokenType but found current token type
        throw new \Exception('Expected '.$tokenType.' but found '.$token->type(). ' token no '.$token->position());
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
            $document->addDirective($this->parseDefinition());
            dump($this->lexer);
            dump($document);
            return $document;
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
                    return 'fragment';//$this->parseFragmentDefenition();
                    break;
            }
        }
        elseif ($this->isType( SupportedTokens::BRACE_L))
        {
            return $this->parseOperationDefinition();
        }

        dump($this->lexer);
        throw new \UnexpectedValueException(
            'previous: '.$this->lexer->previous()->type().' '.$this->lexer->previous()->value().
            ' current: '.$this->lexer->current()->type().' '.$this->lexer->current()->value().
            ' next: '.$this->lexer->next()->type().' '.$this->lexer->next()->value()

        );
    }

     protected function parseOperationDefinition()
     {

         // is it a shorthand query ?
        if($this->isType(SupportedTokens::BRACE_L)){
            return new OperationDefinition(
                'query',
                '',
                [],
                $this->parseSelectionSet()
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
            $this->parseSelectionSet()// selection sets

        /*
        'variableDefinitions' => $this->parseVariableDefinitions(),
            'directives'          => $this->parseDirectives(false),
            'selectionSet'        => $this->parseSelectionSet(),
            'loc'                 => $this->loc($start),
        */

        );
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
        }
         throw new UnexpectedValueException($token);
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
             // while we dont have a closing bracket ) parse each of the variables
            while($this->lexer->current()->type() != SupportedTokens::PAREN_R)
            {
                $arguments[] = $this->parseVariableDefinition();
            }
         }
         return $arguments;
     }

     protected function parseSelectionSet()
     {
         $selections = [];
         if($this->expectedType(SupportedTokens::BRACE_L))
         {
             // while we dont have a closing brace } parse each of the variables
             while($this->lexer->current()->type() != SupportedTokens::BRACE_R)
             {
                 $selections[] = $this->parseSelection();
             }
         }
         return $selections;

     }


     protected function parseSelection()
     {
         $this->lexer->advance();
        if($this->isType(SupportedTokens::SPREAD))
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
            [],//$this->parseArguments(),
            [],//$this->parseDirectives(),
            $this->parseSelectionSet()
        );
     }

     protected function parseVariableDefinition()
     {
        $variable = $this->parseVariable();
        $this->expectedType(SupportedTokens::COLON);
        $type = $this->parseTypeReference();

        die( 'bla');
     }

     protected function parseVariable()
     {
        $this->lexer->expects(SupportedTokens::DOLLAR);
        return $this->parseName();
     }
}
<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/09/2019
 * Time: 22:33
 */

namespace Tools4Schools\Graph\Language;

use Tools4Schools\Graph\Contracts\Language\Lexer as LexerContract;

class Lexer implements LexerContract
{
    protected $text;

    protected $length;

    public $tokens = [];

    protected $position = 0;

    protected $textPosition = 0;


    public function read($text)
    {
        $this->reset();
        $this->text = $text;
        $this->length = mb_strlen($text, 'UTF-8');

        $this->tokens[] = new Token(SupportedTokens::SOF,'');
        $this->tokens[] = $this->readToken();

    }

    protected function reset()
    {
        $this->tokens = [];
        $this->position = 0;
        $this->textPosition = 0;
    }


    // returns the current token
    public function current():Token
    {
        return $this->tokens[$this->position];
    }
    // returns the next token
    public function next():Token
    {
        // if current token is EOF return EOF
        if($this->current()->type() == SupportedTokens::EOF)
        {
            return $this->current();
        }
        return $this->tokens[$this->position + 1];
    }

    // returns the previous token
    public function previous():Token
    {
        // if the current token is SOF return SOF
        if($this->position == 0)
        {
            return $this->current();
        }

        return $this->tokens[$this->position - 1];
    }

    // move the position to the next token
    public function advance():Token
    {
        // if the current token isnt the end of file token
        if($this->current()->type() !== SupportedTokens::EOF)
        {
            $this->tokens[] = $this->readToken();
            $this->position++;
            return $this->previous();
        }

    }

    protected function readToken()
    {
        // remove any whitespace
        $this->skipWhiteSpace();

        // keep track of the starting position
        $textPosition = $this->textPosition;



        // if the position >= text length return end of file token

        if($this->textPosition >= $this->length)
        {
            return new Token(SupportedTokens::EOF,'',$textPosition);
        }

        // is the token punctuation
        if(preg_match('/[!$()=[\]{|}:]|[.]{3}/',$this->text[$textPosition]))
        {
            $this->textPosition ++;
            return new Token($this->text[$textPosition],$this->text[$textPosition],$textPosition);
        }

        // is the next token text
        if(preg_match('/[_A-Za-z][_0-9A-Za-z]*/',$this->text[$textPosition]))
        {
            return $this->readName();
        }

        if(preg_match('/[-,0-9]/',$this->text[$textPosition]))
        {
            return $this->readInteger();
        }

        // if the next character a integer

       // $this->textPosition ++;
        throw new \Exception($this->text[$textPosition]);

        //return $this->text[$textPosition];
    }

    protected function readName():Token
    {
        $startPosition = $this->textPosition;
        $value = '';

        do
        {
            $value .= $this->text[$this->textPosition];
            $this->textPosition++;
        }while(preg_match('/[_A-Za-z][_0-9A-Za-z]*/',$this->text[$this->textPosition]));

        return new Token(SupportedTokens::NAME,$value,$startPosition);
    }

    protected function readInteger():Token
    {
        $startPosition = $this->textPosition;
        $value = '';
        do
        {
            $value .= $this->text[$this->textPosition];
            $this->textPosition++;
        }while(preg_match('/[-,0-9]/',$this->text[$this->textPosition]));

        return new Token(SupportedTokens::INT,$value,$startPosition);
    }


    protected function skipWhiteSpace()
    {
        while($this->textPosition < $this->length)
        {
            if(!preg_match('/[\s,\,]/',$this->text[$this->textPosition]))
            {
               break;
            }
            $this->textPosition++;
        }
    }
}
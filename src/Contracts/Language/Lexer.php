<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 01/10/2019
 * Time: 09:11
 */

namespace Tools4Schools\Graph\Contracts\Language;


use Tools4Schools\Graph\Language\SupportedTokens;
use Tools4Schools\Graph\Language\Token;

interface Lexer
{
    /**
     * Reads the text and converst it to tokens readable bu the parseer
     *
     * @param string $text
     * @return void
     */
    public function read(string $text);

    /**
     * Moves teh cursor to the next token
     *
     * @return Token
     */
    public function advance():Token;

    /**
     * Returns the current token
     *
     * @return Token
     */
    public function current():Token;

    /**
     * Returns the next token
     *
     * @return Token
     */
    public function next():Token;

    /**
     * Returns the previous token
     *
     * @return Token
     */
    public function previous():Token;
}
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
    public function read(string $text);

    public function advance():Token;
}
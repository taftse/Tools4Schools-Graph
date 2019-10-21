<?php

namespace Tools4Schools\Tests\Graph\Parser;


use PHPUnit\Framework\TestCase;
use Tools4Schools\Graph\Language\Lexer;
use Tools4Schools\Graph\Language\Parser;

class ParserTest extends TestCase
{
    protected $parser;
    protected function setUp(): void
    {
        $this->parser = new Parser(new Lexer());
    }

    public function testDocumentHasQuery(){
        $query = "";

        $document = $this->parser->parse($query);


    }

    public function testDocumentHasShortHandQuery()
    {
        $query = "{field}";

        $document = $this->parser->parse($query);


    }



}
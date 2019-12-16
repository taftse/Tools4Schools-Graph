<?php


namespace Tools4Schools\Graph\Tests\Functional\Execution;


use PHPUnit\Framework\TestCase;
use Tools4Schools\Graph\Language\Lexer;
use Tools4Schools\Graph\Language\Parser;

class FieldCollectorTest extends TestCase
{
    protected $request = '{
  a {
    subfield1
  }
  ...ExampleFragment
}

fragment ExampleFragment on Query {
  a {
    subfield2
  }
  b
}';

    protected function setUp(): void
    {
        $parser = new Parser(new Lexer());
        $this->requestDocument = $parser->parse($this->request);

        //$this->schema = new
    }

    public function testCollectFieldsHasFields()
    {

    }




   // public function collectFields(ObjectType $objectType,array $selectionSet = [],array $variableValues= [],array $visitedFragments = [])
}
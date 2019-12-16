<?php


namespace Tools4Schools\Graph\Tests\Functional\Execution;


use PHPUnit\Framework\TestCase;
use Tools4Schools\Graph\Schema\Schema;
use Tools4Schools\Graph\Tests\Fixtures\UserType;

class SchemaTest extends TestCase
{
    protected $schema;

    public function setUp(): void
    {
        $this->schema = new Schema();
    }

    public function testAddType()
    {
        $userType = new UserType();
        $this->schema->addType($userType);

        $this->assertContains($userType,$this->schema->types());

    }
    public function testExecuteUsingSchema()
    {

        $this->markTestIncomplete();
    }

}
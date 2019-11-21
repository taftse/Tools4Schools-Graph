<?php


namespace Tools4Schools\Graph\Types;


use ReflectionClass;
use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType as ObjectTypeContract;
use Tools4Schools\Graph\Contracts\Schema\Types\Query;
use Tools4Schools\Graph\Schema\Types\ObjectType;


abstract class QueryType extends ObjectType implements Query
{

    protected function type()
    {
        return new $this->type;
    }
    /**
     * returns list of arguments
     *
     * @return array
     */
    protected function args() : array
    {
        return [];
    }




    public function fields(): array
    {
        return $this->type()->fields();
    }
}
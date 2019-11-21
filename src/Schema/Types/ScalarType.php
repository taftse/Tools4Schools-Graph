<?php


namespace Tools4Schools\Graph\Schema\Types;


use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType;
use Tools4Schools\Graph\Contracts\Schema\Types\ScalarType as ScalarTypeContract;
use Tools4Schools\Graph\Contracts\Schema\Types\Type;

use Tools4Schools\Graph\Contracts\Types\InputType;
use Tools4Schools\Graph\Contracts\Types\OutputType;
use Tools4Schools\Graph\Schema\Types\Type as BaseType;

abstract class ScalarType extends BaseType implements ScalarTypeContract, InputType,OutputType
{
    public function kind():Type
    {
        return ScalarTypeContract;
    }

    public function resolve(ObjectType $parent = null, array $arguments = [], $context = null, $info = null)
    {
        return $parent->value->{$this->name};
    }
}
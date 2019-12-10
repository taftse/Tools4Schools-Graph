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

    protected function resolver(ObjectType $parent = null, array $arguments = [], $context = null, $info = null)
    {

        // has this Type got a value?
        if(!is_null($this->value))
        {
            // yep lets return it
            return $this->value();
        }

        // has the parent type got a value?
        if(!is_null($parent->value())) {
            // yep but is it an array ? and has it got a value for this type ?
            if (is_array($parent->value()) && isset($parent->value()[$this->name()])) {
                // yep lets return it
                return $parent->value()[$this->name()];
            }
            // nope its an object but does it have a value for this type?
            if(isset($parent->value()->{$this->name()})) {
                // yep lets return it
                return $parent->value()->{$this->name()};
            }
        }
        // nope this type cannot be resolved to a value return null
        return null;
    }
}
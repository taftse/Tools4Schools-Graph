<?php


namespace Tools4Schools\Graph\Types;


use Tools4Schools\Graph\BaseType;

abstract class ScalarType extends BaseType
{
    public function resolve($selectionSet, BaseType $parent = null)
    {
        return $parent->value->{$this->name};
    }
}
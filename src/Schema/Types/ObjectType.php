<?php


namespace Tools4Schools\Graph\Schema\Types;

use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType as ObjectTypeContract;
use Tools4Schools\Graph\Contracts\Schema\Types\Type;

use Tools4Schools\Graph\Contracts\Types\OutputType;
use Tools4Schools\Graph\Schema\Types\Type as BaseType;

abstract class ObjectType extends BaseType implements ObjectTypeContract, OutputType
{
    public function kind():Type
    {
        return ObjectTypeContract;
    }

    public function resolve(ObjectTypeContract $parent = null, array $arguments = [], $context = null, $info = null)
    {
        $result =[];

        foreach ($info->getSelectionSet() as $selection) {
            if($this->hasField($selection->getName()))
            {
                $result[$selection->getNameOrAlias()] = $this->getField($selection->getName())->resolve($this,$arguments,$context,$selection);
            }
        }

        return $result;
    }

    public function hasField(string $fieldName):bool
    {
        foreach ($this->fields() as $field) {
            if($field->name() == $fieldName)
            {
                return true;
            }
        }
        return false;
    }

    public function getField(string $fieldName):Type
    {
        foreach ($this->fields() as $field) {
            if($field->name() == $fieldName)
            {
                return $field;
            }
        }
    }

    public function executeField(ObjectTypeContract $type,$value,$fieldType,$vatiableValue)
    {

    }
}
<?php


namespace Tools4Schools\Graph\Schema\Types;

use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType as ObjectTypeContract;
use Tools4Schools\Graph\Contracts\Schema\Types\Type;

use Tools4Schools\Graph\Contracts\Types\OutputType;
use Tools4Schools\Graph\Schema\Types\Type as BaseType;
use Tools4Schools\Graph\Traits\HasFields;

abstract class ObjectType extends BaseType implements ObjectTypeContract, OutputType
{
    use HasFields;

    public function kind():Type
    {
        return ObjectTypeContract;
    }

    /*public function resolve(ObjectTypeContract $parent = null, array $arguments = [], $context = null, $info = null)
    {
        $result =[];

        foreach ($info->getSelectionSet() as $selection) {
            if($this->hasField($selection->getName()))
            {
                $result[$selection->getNameOrAlias()] = $this->getField($selection->getName())->resolve($this,$arguments,$context,$selection);
            }
        }

        return $result;
    }*/

    protected function resolver(ObjectTypeContract $parent = null, array $arguments = [], $context = null, $info = null)
    {
        dd($parent);
    }


   /* public function executeField(ObjectTypeContract $type,$value,$fieldType,$vatiableValue)
    {

    }*/
}
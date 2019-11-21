<?php


namespace Tools4Schools\Graph\Fields;


use Tools4Schools\Graph\BaseType;

use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType;

abstract class RelationField extends Field
{
    protected $type;

    public function resolve(ObjectType $parent = null, array $arguments = [], $context = null, $info = null)
    {
        $result = [];
        dump($info->getName());
        dump($parent->value->types());





/*









            foreach ($this->value as $value) {
                //$this->value = $value;
                $result[] = $this->type()->resolve($value, [], $context, $info);
            }*/


        return $result;
    }

    /*public function sresolve($selectionSet, BaseType $parent = null)
    {

        // if $requestNode has
        //$this->value = $parent->value[$selectionSet->getName()];

        foreach($parent->value[$selectionSet->getName()] as $value)
        {
            $this->value = $value;
            $result[] = $this->type()->resolve($selectionSet,$this);
        }
        return $result;
    }*/
}
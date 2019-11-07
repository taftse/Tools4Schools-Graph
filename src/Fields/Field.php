<?php
namespace Tools4Schools\Graph\Fields;



use GraphQL\Type\Definition\Type as GraphqlType;
use Tools4Schools\Graph\BaseType;
use Tools4Schools\Graph\Types\ListType;

abstract class Field extends BaseType
{

    public function __construct(string $name,string $attribute = null,$resolveCallback = null)
    {
        $this->name = $name;
    }

    protected function args():array
    {
        return [];
    }


    /*public function resolve($resource,$attribute = null)
    {
        return $this->name;
    }*/


/*
    protected function completeValue($fields,$result,$variableValues)
    {
        if(!is_null($this->type()))
        {
            switch (true)
            {
                case $this->type() instanceof ListType:
                    break;
            }
        }
    }*/
}
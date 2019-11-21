<?php
namespace Tools4Schools\Graph\Fields;




use Tools4Schools\Graph\Schema\Types\Type as BaseType;
use Tools4Schools\Graph\Contracts\Schema\Types\Type;
use Tools4Schools\Graph\Types\ListType;

abstract class Field extends BaseType implements Type
{

    public function __construct(string $name,string $attribute = null,$resolveCallback = null)
    {
        parent::__construct($name);
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
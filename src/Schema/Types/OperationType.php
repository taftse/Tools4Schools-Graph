<?php


namespace Tools4Schools\Graph\Schema\Types;


use Tools4Schools\Graph\Contracts\Schema\Types\OperationType as OperationTypeContract;


class OperationType extends  ObjectType implements OperationTypeContract//ObjectType
{

    protected $fields = [];




    public function __construct(string $name = '')
    {
        parent::__construct($name);
    }



    public function fields(): array
    {
        return $this->fields;
    }


    public function addOperation(OperationTypeContract $operation)
    {
         $this->fields[$operation->name()] = $operation;
    }
/*
    public function hasField(string $fieldName):bool
    {
        foreach ($this->items as $item) {
            if($item->name() == $fieldName)
            {
                return true;
            }
        }
        return false;
    }

    public function getField(string $fieldName):Type
    {
        foreach ($this->items as $item) {
            if($item->name() == $fieldName)
            {
                return $item;
            }
        }
    }*/
}
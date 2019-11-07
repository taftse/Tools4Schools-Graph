<?php


namespace Tools4Schools\Graph;

use Tools4Schools\Graph\Language\AST\Field;
use Tools4Schools\Graph\Types\ListType;


abstract class ObjectType extends BaseType
{

    //public static $name;

    //public static $description ='';

    abstract public function fields():array;


    /**
     * @param Collection $requestedFields
     * @param BaseType|null $parent
     * @return array
     */
    public function resolve($node,BaseType $parent = null)
    {
        $result =[];
        // if $requestNode has

        foreach ($node->getSelectionSet() as $selection) {
            if($this->hasField($selection->getName()))
            {
                $result[$selection->getNameOrAlias()] = $this->getField($selection->getName())->resolve($selection,$this);
            }
        }

        return $result;

        // foreach $requestNode->selectionset() as selection
        // if this ->has field(selection->name())
        //this->getField(selection->name)->resolve()

        //parent::resolve($requestNode); // TODO: Change the autogenerated stub
    }

    protected function hasField($fieldName)
    {
        foreach ($this->fields() as $field) {
            if($field->name() == $fieldName)
            {
                return true;
            }
        }
        return false;
    }

    protected function getField($fieldName)
    {
        foreach ($this->fields() as $field) {
            if($field->name() == $fieldName)
            {
                return $field;
            }
        }
    }
}
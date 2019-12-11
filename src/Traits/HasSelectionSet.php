<?php


namespace Tools4Schools\Graph\Traits;


//use Tools4Schools\Graph\Contracts\Schema\Types\FieldType;

trait HasSelectionSet
{
    protected $selectionSet = [];



    public function getSelectionSet():array
    {
        return $this->selectionSet;
    }

    public function addField( $field)
    {
        $this->selectionSet[] = $field;
    }
}
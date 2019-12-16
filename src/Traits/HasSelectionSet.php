<?php


namespace Tools4Schools\Graph\Traits;


//use Tools4Schools\Graph\Contracts\Schema\Types\FieldType;

use Tools4Schools\Graph\Language\AST\SelectionSet;

trait HasSelectionSet
{
    protected $selectionSet;



    public function getSelectionSet():SelectionSet
    {
        return $this->selectionSet;
    }

    public function addField( $field)
    {
        $this->selectionSet->addField( $field);
    }
}
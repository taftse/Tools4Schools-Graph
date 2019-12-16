<?php


namespace Tools4Schools\Graph\Language\AST;


class SelectionSet
{
    protected $selectionSet = [];

    public function addField($field)
    {
        if($field instanceof InlineFragment)
        {
            $this->selectionSet[] = $field;
        }else{
            $this->selectionSet[$field->name()] = $field;
        }

    }

    public function toArray():array
    {
        return $this->selectionSet;
    }

    public function mergeSelectionSets(SelectionSet $selectionSet)
    {
        foreach ($selectionSet->toArray() as $selection)
        {
            $this->addField($selection);
        }
    }
}
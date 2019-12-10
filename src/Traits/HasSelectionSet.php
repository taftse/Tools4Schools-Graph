<?php


namespace Tools4Schools\Graph\Traits;


trait HasSelectionSet
{
    protected $selectionSet = [];



    public function getSelectionSet():array
    {
        return $this->selectionSet;
    }
}
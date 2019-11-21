<?php


namespace Tools4Schools\Graph\Traits;


trait HasName
{
    protected $name = '';

    public function name():string
    {
        return $this->name;
    }
}
<?php


namespace Tools4Schools\Graph\Traits;


trait HasValue
{
    protected $value = null;

    public function value()
    {
        return  $this->value;
    }
}
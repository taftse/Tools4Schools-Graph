<?php


namespace Tools4Schools\Graph\Language\AST;


class Argument
{
    protected $name;

    protected $value;

    public function __construct($name,$value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
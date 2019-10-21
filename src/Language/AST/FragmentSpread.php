<?php


namespace Tools4Schools\Graph\Language\AST;


class FragmentSpread
{
    protected $name;

    protected $directives = [];

    public function __construct($name = null ,array $directives =[])
    {
        $this->name = $name;
        $this->directives = $directives;
    }
}
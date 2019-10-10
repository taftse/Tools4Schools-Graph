<?php

namespace Tools4Schools\Graph\Language\AST;


class Field
{

    protected $name;

    protected $alias = null;

    protected $arguments = [];

    protected $directives = [];

    protected $selectionSets = [];

    public function __construct($name,$alias = null,array $arguments,array $directives,$selectionSets)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->arguments = $arguments;
        $this->directives = $directives;
        $this->selectionSets = $selectionSets;
    }
}
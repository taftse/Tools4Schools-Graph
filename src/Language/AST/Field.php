<?php

namespace Tools4Schools\Graph\Language\AST;

use Tools4Schools\Graph\Contracts\Language\Request\AST\Node as NodeContract;


class Field extends Node implements NodeContract
{
    protected $alias = null;

    protected $arguments = [];

    public function __construct($name,$alias = null,array $arguments = [],array $directives,$selectionSet)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->arguments = $arguments;
        $this->directives = $directives;
        $this->selectionSet = $selectionSet;
    }

    public function getNameOrAlias()
    {
        if(!is_null($this->alias))
        {
            return $this->alias;
        }
        return $this->name;
    }

    public function hasArguments():bool
    {
        return !is_null($this->arguments);
    }

    public function getArguments():array
    {
        return $this->arguments;
    }
}
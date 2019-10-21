<?php


namespace Tools4Schools\Graph\Language\AST;


class InlineFragment
{
    protected $namedType = '';

    protected $directives = [];

    protected $selectionSets = [];

    public function __construct($typeCondition = null,array $directives = [],array $selectionSets)
    {
        $this->namedType = $typeCondition;
        $this->directives = $directives;
        $this->selectionSets = $selectionSets;
    }
}
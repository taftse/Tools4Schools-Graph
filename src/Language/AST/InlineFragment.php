<?php


namespace Tools4Schools\Graph\Language\AST;


use Tools4Schools\Graph\Traits\HasSelectionSet;

class InlineFragment
{
    use HasSelectionSet;

    protected $namedType = '';

    protected $directives = [];



    public function __construct($typeCondition = null,array $directives = [],array $selectionSets)
    {
        $this->namedType = $typeCondition;
        $this->directives = $directives;
        $this->selectionSets = $selectionSets;
    }
}
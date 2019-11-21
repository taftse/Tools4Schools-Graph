<?php


namespace Tools4Schools\Graph\Contracts\Language\Request\AST;


use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType;

interface Node
{
    //public function collectFields(ObjectType $ObjectType,$variableValues,array $visitedFragments = []):array;

    public function name(): string;
}
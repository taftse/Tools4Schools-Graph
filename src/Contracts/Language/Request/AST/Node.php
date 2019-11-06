<?php


namespace Tools4Schools\Graph\Contracts\Language\Request\AST;


interface Node
{
    public function collectFields(ExecutableDefinition $ObjectType,$variableValues,array $visitedFragments = []):array;

    public function getName(): string;
}
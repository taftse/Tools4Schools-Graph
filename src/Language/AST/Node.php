<?php


namespace Tools4Schools\Graph\Language\AST;

use Tools4Schools\Graph\Contracts\Language\Request\AST\ExecutableDefinition;
use Tools4Schools\Graph\Contracts\Language\Request\AST\Node as NodeContract;

abstract class Node implements NodeContract
{
    protected $name;

    protected $directives = [];

    protected $selectionSet = [];

    public function collectFields(ExecutableDefinition $ObjectType,$variableValues,array $visitedFragments = []):array
    {
        $groupedFields = [];

        if (!is_null($this->selectionSet)) {
            foreach ($this->selectionSet as $selection) {

                if ($selection->hasDirective('skip')) {
                    continue;
                }

                if ($selection->hasDirective('include')) {
                    continue;
                }


                switch (true) {
                    case $selection instanceof Field:
                        $groupedFields[$selection->getNameOrAlias()] = $selection->collectFields($ObjectType, $variableValues, $visitedFragments);
                        break;
                    case $selection instanceof FragmentSpread:
                        // If fragmentSpreadName is in visitedFragments, continue with the next selection in selectionSet
                        if(isset($visitedFragments[$selection->getName()]))
                        {
                            break;
                        }
                        //Add fragmentSpreadName to visitedFragments
                        array_push($visitedFragments,$selection->getName());


                        $groupedFields[$selection->getName()];
                        // @todo implement fragment spread
                        break;
                    case $selection instanceof InlineFragment:
                        // @todo implement inline fragment
                        break;
                    default:
                        break;
                }
            }
        }


        return $groupedFields;
    }

    /**
     * Gets the name of the node
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getSelectionSet()
    {
        return $this->selectionSet;
    }

}
<?php


namespace Tools4Schools\Graph\Language\AST;

use Tools4Schools\Graph\Contracts\Language\Request\AST\ExecutableDefinition;
use Tools4Schools\Graph\Contracts\Language\Request\AST\Node as NodeContract;
use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType;
use Tools4Schools\Graph\Traits\HasName;

abstract class Node implements NodeContract
{
    use HasName;

    protected $directives = [];

    protected $selectionSet = [];

    protected $location;

    public function collectFields(ObjectType $objectType,$variableValues,array $visitedFragments = []):array
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
                        $groupedFields[$selection->getNameOrAlias()] = $selection->collectFields($objectType, $variableValues, $visitedFragments);
                        break;
                    case $selection instanceof FragmentSpread:
                        // If fragmentSpreadName is in visitedFragments, continue with the next selection in selectionSet
                        if(isset($visitedFragments[$selection->name()]))
                        {
                            break;
                        }
                        //Add fragmentSpreadName to visitedFragments
                        array_push($visitedFragments,$selection->name());
                        if(!$objectType->hasFragment($selection->name()))
                        {
                            break;
                        }
                        $fragment  = $objectType->getFragment($selection->name());

                        if(!$this->doesFragmentTypeApply($ObjectType,$fragment->typeCondition()))
                        {
                            break;
                        }

                        $fragmentSelectionSet = $fragment->getSelectionSet();

                        $fragmentGroupFieldsSet = $this->collectFields($ObjectType,$fragmentSelectionSet,$visitedFragments);

                        $groupForResponseKey = [];

                        foreach($fragmentGroupFieldsSet as $responseKey=>$fragmentGroup)
                        {
                            array_push($groupForResponseKey,$fragmentGroup);
                        }
                        $groupedFields[$responseKey] = $groupForResponseKey;


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
    }*/

    /**
     * Gets the name of the node
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name();
    }

    public function getSelectionSet()
    {
        return $this->selectionSet;
    }

}
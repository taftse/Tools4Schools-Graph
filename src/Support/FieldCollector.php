<?php


namespace Tools4Schools\Graph\Support;


use Tools4Schools\Graph\Contracts\Request\Document;
use Tools4Schools\Graph\Contracts\Types\AbstractType;
use Tools4Schools\Graph\Contracts\Types\ObjectType;
use Tools4Schools\Graph\Contracts\Types\UnionType;
use Tools4Schools\Graph\Schema\Schema;
use Tools4Schools\Graph\Schema\Types\InterfaceType;

class FieldCollector
{
   protected $requestDocument;

   protected $schema;

   public function __construct(Schema $schema,Document $requestDocument)
   {
       $this->requestDocument = $requestDocument;
       $this->schema;
   }

    public function collectFields(ObjectType $objectType,array $selectionSet = [],array $variableValues= [],array $visitedFragments = [])
    {
        $groupedFields = [];
        foreach ($selectionSet as $selection)
        {
            // @todo change how to execute directives
            if($selection->hasDirective('skip'))
            {
                continue;
            }

            if($selection->hasDirective('include') && $selection->getDirective('include')->execute() != true)
            {
                continue;
            }

            switch (true) {
                case $selection instanceof Field:
                    $groupedFields[$selection->getNameOrAlias()] = $selection;
                    break;
                case $selection instanceof FragmentSpread:
                    // If fragmentSpreadName is in visitedFragments, continue with the next selection in selectionSet
                    if(isset($visitedFragments[$selection->name()]))
                    {
                        break;
                    }
                    //Add fragmentSpreadName to visitedFragments
                    if(!$this->requestDocument->hasFragment($selection->name()))
                    {
                        // error Fragment does not exist
                        break;
                    }

                    array_push($visitedFragments,$selection->name());

                    $fragment  = $this->requestDocument->getFragment($selection->name());

                    if(!$this->schema->hasType($fragment->typeCondition()))
                    {
                        /// error cannot spread fragment as type does not exist as part of the schema
                        break;
                    }


                    if(!$this->doesFragmentTypeApply($objectType,$this->schema->getType($fragment->typeCondition())))
                    {
                        break;
                    }

                    $fragmentSelectionSet = $fragment->getSelectionSet();

                    $fragmentGroupFieldsSet = $this->collectFields($objectType,$fragmentSelectionSet,[],$visitedFragments);

                    $groupForResponseKey = [];

                    foreach($fragmentGroupFieldsSet as $fragmentGroup)
                    {
                        array_push($groupForResponseKey,$fragmentGroup);
                    }
                    $groupedFields[$selection->name()] = $groupForResponseKey;
                    break;
                case $selection instanceof InlineFragment:
                    if(!is_null($selection->typeCondition()) && !$this->doesFragmentTypeApply($objectType,$fragment->typeCondition()))
                    {
                        break;
                    }
                    $fragmentSelectionSet = $selection->getSelectionSet();

                    $fragmentGroupFieldsSet = $this->collectFields($objectType,$fragmentSelectionSet,$variableValues,$visitedFragments);

                    foreach($fragmentGroupFieldsSet as $fragmentGroup)
                    {
                        array_push($groupForResponseKey,$fragmentGroup);
                    }
                    $groupedFields[$selection->name()] = $groupForResponseKey;

            }
        }
        return $groupedFields;
    }

    protected function doesFragmentTypeApply(ObjectType $objectType,$fragmentType)
    {
        switch (true) {
            case $fragmentType instanceof ObjectType:
                return $fragmentType->type() == $objectType->type();
                break;
            case $fragmentType instanceof InterfaceType:
                //@todo fix this function for proper implementation
                return false;
                break;
            case $fragmentType instanceof UnionType:
                //@todo fix this function for proper implementation
                return false;
                break;
        }
    }
}
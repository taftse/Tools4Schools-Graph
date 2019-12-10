<?php


namespace Tools4Schools\Graph\Resolvers;


use Tools4Schools\Graph\Contracts\Schema\Schema;
use Tools4Schools\Graph\Contracts\Request\OperationDefinition;
use Tools4Schools\Graph\Contracts\Types\InputType;

class ValuesResolver
{
    public static function CoerceVariableValues(Schema $schema, OperationDefinition $operation,$variableValues)
    {
        $coercedValues = [];
        $variableDefinitions = $operation->getVariableDefinitions();
        foreach ($variableDefinitions as $definition)
        {
            // does this schema have a type
            //dump($this->schema->getType($definition->name()));
            if($schema->hasType($definition->type()->type()) && ($schema->getType($definition->type()->type()) instanceof InputType))
            {

                // if there is no variable set for this input
                if(!array_key_exists($definition->name(),$variableValues)) {
                    // there is also no default send an error
                    if (!is_null($definition->defaultValue())) {
                        $coercedValues[$definition->name()] = $definition->defaultValue();
                        continue;
                    }
                    Throw new \Exception("query error");
                }

                if($definition->type()->isRequired() && is_null($variableValues[$definition->name()]))
                {
                    Throw new \Exception("query error");
                }

                $coercedValues[$definition->name()] = $variableValues[$definition->name()];

            }

        }
        return $coercedValues;
    }
}
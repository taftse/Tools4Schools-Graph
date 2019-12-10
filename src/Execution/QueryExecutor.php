<?php


namespace Tools4Schools\Graph\Execution;


use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType;
use Tools4Schools\Graph\Exceptions\UndefinedFieldException;

class QueryExecutor extends AbstractExecutor
{
    /**
     * @inheritDoc
     */
    public function executeFields(ObjectType $parentType ,$rootValue,array $path,array $fields)
    {
        $results = [];

        foreach ($fields as $fieldName=>$field)
        {
            try{
                $result = $this->resolveField($parentType,$rootValue,$field);
            }catch (UndefinedFieldException $exception)
            {
                continue;
            }


            $results[$fieldName] = $result;
        }
    }
}
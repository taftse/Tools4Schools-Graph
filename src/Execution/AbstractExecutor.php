<?php


namespace Tools4Schools\Graph\Execution;


use Tools4Schools\Graph\Contracts\Request\Document;
use Tools4Schools\Graph\Contracts\Request\OperationDefinition;
use Tools4Schools\Graph\Contracts\Schema\Schema;
use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType;
use Tools4Schools\Graph\Exceptions\UndefinedFieldException;
use Tools4Schools\Graph\Schema\Types\Type;
use Tools4Schools\Graph\Support\FieldCollector;

abstract class AbstractExecutor
{
    protected $schema;

    protected $request;

    protected $fieldCollector;

    public function __construct(Schema $schema,Document $request)
    {
        $this->schema = $schema;
        $this->request = $request;
        $this->fieldCollector = new FieldCollector($schema,$request);
    }

    abstract public function executeFields(ObjectType $parentType ,$rootValue,array $path,array $fields);



    public function execute(OperationDefinition $requestOperation,  $variableValues = null, $initialValue = null)
    {
        $rootOperationType = $this->getOperationType($requestOperation);

        $fields = $this->fieldCollector->collectFields($rootOperationType,$requestOperation->getSelectionSet(),$variableValues);
        dd($fields);
        $path = [];
        try{
            $result = $this->executeFields($rootOperationType,null,$path,$fields);
        }catch (\Exception $exception)
        {

        }
    }

    protected function getOperationType(OperationDefinition $operation): ?ObjectType
    {
        switch ($operation->getType()) {
            case "query":
                return $this->schema->getQueryType();
            case "migration":
                return $this->schema->getMutationType();
            case "subscription":
               return $this->schema->getSubscriptionType();
            default:
                throw new ExcecutionException("unsupported operation");
        }
    }

    protected function resolveField(ObjectType $parentType,$rootValue,array $field )
    {

        // to comply with the specification
        $field = $field[0];

        if(is_array($field))
        {
            dd($field);
        }
        $name = $field->name();
        dump($name);
        $fieldDefinition = $this->getFieldDefinition($parentType,$name);

        if(is_null($fieldDefinition))
        {
            throw new UndefinedFieldException($field->name());
        }
        dump($fieldDefinition);
       // determineResolveCallback($field,$parentType)

        dd($fieldDefinition->resolve());
    }

    protected function getFieldDefinition(ObjectType $parentType,string $fieldName):?Type
    {
        if($fieldName === '__schema' && $this->schema->getQueryType() === $parentType)
        {
            dd('return Schema Introspection (AbstractExecutor.php=>getFieldDefinition()');
        }
        if($fieldName === '__type' && $this->schema->getQueryType() === $parentType)
        {
            dd('return Type Introspection (AbstractExecutor.php=>getFieldDefinition()');
        }
        if($fieldName === '__typename')
        {
            dd('return typename Introspection (AbstractExecutor.php=>getFieldDefinition()');
        }

        return $parentType->getField($fieldName);
    }
}
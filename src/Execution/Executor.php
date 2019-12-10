<?php


namespace Tools4Schools\Graph\Execution;

use Tools4Schools\Graph\Contracts\Request\Document;
use Tools4Schools\Graph\Contracts\Schema\Schema;
use Tools4Schools\Graph\Resolvers\ValuesResolver;

class Executor
{
    /**
     * The schema this executor executes
     *
     * @var Schema $schema
     */
    public $schema;




    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    public function execute(Document $requestDocument,string $operationName = null,$variableValues = null,$initialValue = null)
    {
        $operation = $requestDocument->getOperation($operationName);

        $coercedVariableValues = ValuesResolver::CoerceVariableValues($this->schema, $operation, $variableValues);

        switch ($operation->getType()) {
            case "query":
                return $this->getQueryExecutor($requestDocument)->execute($operation,$coercedVariableValues,$initialValue);//executeQuery($operation,$coercedVariableValues,$initialValue);
            case "migration":
                return $this->getMutationExecutor($requestDocument)->execute($operation,$coercedVariableValues,$initialValue);//executeMutation($operation,$coercedVariableValues,$initialValue);
            case "subscription":
                return $this->getSubscriptionExecutor($requestDocument)->execute($operation,$coercedVariableValues,$initialValue);//executeSubscription($operation,$coercedVariableValues,$initialValue);
            default:
                throw new \Exception("unsupported operation");
        }
    }


    protected function getQueryExecutor(Document $requestDocument):AbstractExecutor
    {
        return new QueryExecutor($this->schema,$requestDocument);
    }

    protected function getMutationExecutor(Document $requestDocument): AbstractExecutor
    {
        return new MutationExecutor($this->schema,$requestDocument);
    }

    protected function getSubscriptionExecutor(Document $requestDocument): AbstractExecutor
    {
        return new SubscriptionExecutor($this->schema,$requestDocument);
    }
}
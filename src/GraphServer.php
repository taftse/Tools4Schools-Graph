<?php


namespace Tools4Schools\Graph;


use Tools4Schools\Graph\Contracts\Resolver;
use Tools4Schools\Graph\Contracts\Types\InputType;
use Tools4Schools\Graph\Contracts\Schema\Types\Type;

use ReflectionClass;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Tools4Schools\Graph\Exceptions\TypeNotFoundException;
use Tools4Schools\Graph\Language\AST\Field;
use Tools4Schools\Graph\Language\AST\FragmentDefinition;
use Tools4Schools\Graph\Language\AST\FragmentSpread;
use Tools4Schools\Graph\Language\AST\InlineFragment;
use Tools4Schools\Graph\Language\AST\OperationDefinition;
use Tools4Schools\Graph\Language\AST\Types\NonNullType;
use Tools4Schools\Graph\Language\Lexer;
use Tools4Schools\Graph\Language\Parser;
use Tools4Schools\Graph\Language\AST\Document;
use Tools4Schools\Graph\Schema\Schema;
use Tools4Schools\Graph\Schema\Types\ObjectType;

//use Tools4Schools\Graph\Schema\Types\Type;


class GraphServer
{
    public $resolvers = [];


    /**
     * the schema instance of this server
     *
     * @var Schema
     */
    public $schema;

    /**
     * Get the URI path prefix utilized by Graph server.
     *
     * @return string
     */
    public static function path():string
    {
        return config('graph.path', '/graph');
    }


    /**
     * Get the current GraphServer version.
     *
     * @return string
     */
    public static function version()
    {
        return '0.1';
    }


    public function __construct()
    {
        $this->schema = new Schema();
    }

    /**
     * Add a resolver to the list of available resolvers
     *
     * @param Resolver $resolver
     */
   /* public function registerResolver(Resolver $resolver):void
    {
        $this->resolvers[$resolver->name()] = new $resolver;
    }

    /**
     * returns a resolver instance
     * @param string $resolverName
     * @return Resolver
     */
    /*public function getResolver(string $resolverName):Resolver
    {
        if($this->hasResolver($resolverName)) {
            return $this->resolvers[$resolverName];
        }

        throw new ResolverNotFoundException("no resolver of the type [".$resolverName."] Found");
    }

    public function hasResolver(string $resolverName):bool
    {
        return isset($this->resolvers[$resolverName]);
    }*/

    /**
     * Register the given types.
     *
     * @param  array  $types
     * @return static
     */
     public function types(array $types)
     {
         $this->schema->addType($types);
     }
        /**
         * Register all of the type classes in the given directory.
         *
         * @param  string  $directory
         * @return void
         */
     public function typesIn($directory)
     {
         $namespace = app()->getNamespace();

         foreach ((new Finder())->in($directory)->files() as $file){
             $file = $namespace.str_replace(
                     ['/', '.php'],
                     ['\\', ''],
                     Str::after($file->getPathname(), app_path().DIRECTORY_SEPARATOR)
                 );
             if(is_subclass_of($file, Type::class) &&
                 ! (new ReflectionClass($file))->isAbstract()) {
                 $this->schema->addType(new $file);
             }
         }


     }

    protected $requestDocument;

    public function query(string $query,string $operationName = null,$variableValue = null){

        $parser = new Parser(new Lexer());
        $this->requestDocument = $parser->parse($query);

        return $this->executeRequest($this->requestDocument,$operationName,$variableValue);
    }




    protected function executeRequest(Document $requestDocument,string $operationName = null,$variableValues = null,$initialValue = null)
    {
        $operation = $requestDocument->getOperation($operationName);

        $coercedVariableValues = $this->CoerceVariableValues($this->schema, $operation, $variableValues);

        switch ($operation->getType()) {
            case "query":
                return $this->executeQuery($operation,$coercedVariableValues,$initialValue);
            case "migration":
                return $this->executeMutation($operation,$coercedVariableValues,$initialValue);
            case "subscription":
                return $this->executeSubscription($operation,$coercedVariableValues,$initialValue);
            default:
                throw new \Exception("unsupported operation");
        }
    }

    protected function executeQuery(OperationDefinition $query,  $variableValues = null, $initialValue = null)
    {

        $queryType = $this->schema->getType('Query');
        $selectionSet = $query->getSelectionSet();



        $data = $this->executeSelectionSet($selectionSet,$queryType,$initialValue,$variableValues);




        // check that the query type exists on the schema
       // dump($this->schema->getType('query')->hasField('__schema'));

        //if($this->schema->getType('query')->hasField())
//dump($this->schema);
       /* $results = [];

        foreach ($query->getSelectionSet() as $field) {
            // if field exists in the schema

            if ($this->schema->getType('Query')->hasField($field->getName())) {
                $results['data'][$field->getName()] = $this->schema->getType('Query')->getField($field->getName())->resolve(null, [], $this->resolvers, $field);
            } else {
                $results['errors']['message'] = 'cannot query field \"' . $field->getName() . '\" on type \"' . $query->getType() . '\".';
            }
        }
        return $results;
        //$selectionSet = $query->collectFields($query,$variableValues);//$query->getSelectionSet();

        //$data = $this->executeSelectionSet($selectionSet,$queryType,$initialValue,$variableValues);
        //return$data ;*/
    }

    protected function executeMutation(OperationDefinition $operation, Schema $schema, $coercedVariableValues = null, $initialValue = null)
    {
        return'Mutate';
    }

    protected function executeSubscription(OperationDefinition $operation, Schema $schema, $coercedVariableValues = null, $initialValue = null)
    {
        return'Subscribed';
    }


    protected function executeSelectionSet($selectionSet,$objectType,$objectValue,$variableValues)
    {

        //dd($selectionSet->collectFields($objectType,$selectionSet,$variableValues));
        $groupedFieldSet = $objectType->collectFields($this->request,$selectionSet,$variableValues);
       // $groupedFieldSet = $this->collectFields($objectType,$selectionSet,$variableValues);



        $result = [];
        foreach($groupedFieldSet as $responseKey => $fields)
        {
            $fieldName = $field->name();
            $fieldType = $field->type();
            if($this->schema->hasType($fieldType))
            {
                $responseValue = ExecuteField($objectType,$objectValue,$fields,$fieldType,$variableValues);
                $result[$responseKey] = $responseValue;
            }
        }
        return $result;

    }

    protected function collectFields(ObjectType $objectType,array $selectionSet = [],array $variableValues= [],array $visitedFragments = [])
    {
        $groupedFields = [];
        foreach ($selectionSet as $selection)
        {
            if($selection->hasDirective('skip'))
            {
                continue;
            }

            if($selection->hasDirective('include') && $selection->getDirective('include') != true)
            {
                continue;
            }



            switch (true) {
                case $selection instanceof Field:
                    $groupedFields[$selection->getNameOrAlias()] = $selection->collectFields($objectType, $variableValues, $visitedFragments);
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
        return $groupedFields;
    }

    protected function  CoerceVariableValues(Schema $schema, OperationDefinition $operation,$variableValues)
    {
        $coercedValues = [];
        $variableDefinitions = $operation->getVariableDefinitions();
        foreach ($variableDefinitions as $definition)
        {
            // does this schema have a type
            //dump($this->schema->getType($definition->name()));
            if($this->schema->hasType($definition->type()->type()) && ($this->schema->getType($definition->type()->type()) instanceof InputType))
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
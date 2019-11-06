<?php


namespace Tools4Schools\Graph;


//use GraphQL\GraphQL;
//use GraphQL\Type\Definition\ObjectType;
//use GraphQL\Type\Definition\Type as GraphqlType ;
//use GraphQL\Type\Definition\Type;
//use GraphQL\Type\Schema;
use ReflectionClass;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Tools4Schools\Graph\Exceptions\TypeNotFoundException;
use Tools4Schools\Graph\Language\AST\Field;
use Tools4Schools\Graph\Language\AST\FragmentDefinition;
use Tools4Schools\Graph\Language\AST\FragmentSpread;
use Tools4Schools\Graph\Language\AST\InlineFragment;
use Tools4Schools\Graph\Language\AST\OperationDefinition;
use Tools4Schools\Graph\Language\Lexer;
use Tools4Schools\Graph\Language\Parser;
use Tools4Schools\Graph\Language\AST\Document;
use Tools4Schools\Graph\Schema\Schema;

class GraphServer
{
    /**
     * the schema instance of this server
     *
     * @var Schema
     */
    public $schema;

    /**
     * Get the URI path prefix utilized by Nova.
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




    public function query(string $query,string $operationName = null,$variableValue = null){

        $parser = new Parser(new Lexer());
        $requestDocument = $parser->parse($query);

        return $this->executeRequest($requestDocument,$operationName,$variableValue);
    }




    protected function executeRequest(Document $requestDocument,string $operationName = null,$variableValue = null,$initialValue = null)
    {
        $operation = $requestDocument->getOperation($operationName);

        $coercedVariableValues = '';//$this->CoerceVariableValues(schema, operation, variableValues);

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

        // check that the query type exists on the schema



        foreach ($query->getSelectionSet() as $field) {
            // if field exists in the schema
           // dump($field);
            //dump($this->schema);
            if($this->schema->hasType($field->getName()))
            {
               $this->schema->getType($field->getName())->resolve($field);
            }
        }
return '';
        //$selectionSet = $query->collectFields($query,$variableValues);//$query->getSelectionSet();

        //$data = $this->executeSelectionSet($selectionSet,$queryType,$initialValue,$variableValues);
        //return$data ;
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
        $groupedFieldSet = $selectionSet;//$objectType->collectFields($objectType,$selectionSet,$variableValues);
        dump($groupedFieldSet);
        $result = [];
        foreach($groupedFieldSet as $field)
        {
            //$result[$field->name()] =
        }




    }

    protected function  CoerceVariableValues(Schema $schema, OperationDefinition $operation,$variableValues)
    {

    }


}
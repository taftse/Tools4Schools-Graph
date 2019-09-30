<?php


namespace Tools4Schools\Graph;


use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type as GraphqlType ;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use ReflectionClass;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use Tools4Schools\Graph\Exceptions\TypeNotFoundException;

class GraphServer
{
    /**
     * The registered resource names. (Types Definitions)
     *
     * @var array
     */
    public static $resources = [];

    /**
     * The registered query names. (Query Definitions)
     *
     * @var array
     */
    public static $queries = [];


    /**
     * The registered mutation names. (Mutation Definitions)
     *
     * @var array
     */
    public static $mutations = [];



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

    /**
     * Register the given resources.
     *
     * @param  array  $resources
     * @return static
     */
    public static function resources(array $resources):GraphServer
    {
        static::$resources = array_merge(static::$resources,$resources);

        return new static;
    }

    /**
     * Register all of the resource classes in the given directory.
     *
     * @param  string  $directory
     * @return void
     */
    public static function resourcesIn($directory)
    {
        $resources = static::getFiles($directory,Resource::class);

        static::resources(
            collect($resources)->sort()->all()
        );
    }

    /**
     * Register the given queries.
     *
     * @param  array  $resources
     * @return static
     */
    public static function queries(array $queries):GraphServer
    {
        static::$queries = array_merge(static::$queries,$queries);

        return new static;
    }
    /**
     * Register all of the resource classes in the given directory.
     *
     * @param  string  $directory
     * @return void
     */
    public static function queriesIn($directory)
    {
        $queries = static::getFiles($directory,Query::class);

        static::queries(
            collect($queries)->sort()->all()
        );

    }


    protected static function getFiles($directory,$type):array
    {
        $namespace = app()->getNamespace();

        $files = [];

        foreach ((new Finder())->in($directory)->files() as $file){
            $file = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($file->getPathname(), app_path().DIRECTORY_SEPARATOR)
                );
            if(is_subclass_of($file, $type) &&
                ! (new ReflectionClass($file))->isAbstract()) {
                $files[$file] = new $file;
            }
        }

        return $files;
    }
    /**
     * Register the given queries.
     *
     * @param  array  $resources
     * @return static
     */
    public static function mutations(array $mutations):GraphServer
    {
        static::$mutations = array_merge(static::$mutations,$mutations);

        return new static;
    }
    /**
     * Register all of the resource classes in the given directory.
     *
     * @param  string  $directory
     * @return void
     */
    public static function mutationsIn($directory)
    {
        $mutations = static::getFiles($directory,Mutation::class);

        static::mutations(
            collect($mutations)->sort()->all()
        );
    }

    /**
     * @param  Schema|array|string|null  $schema
     * @return Schema
     */
    public function schema($schema = null): Schema
    {
        if ($schema instanceof Schema) {
            return $schema;
        }

        try {
            $schema = new Schema([
                'query' => new ObjectType(['name'=>'Query','fields'=>[$this->toGraphType(static::$queries)]]),
                //'mutations' =>$this->toGraphType(static::$mutations),
               // 'subscriptions' =>'',
                //'types' => $this->toGraphType(static::$resources),
            ]);


            $schema->assertValid();
        } catch (GraphQL\Error\InvariantViolation $e) {
            dump($e->getMessage());
        }
        return $schema;
    }


    public static function type(string $name):GraphqlType
    {
        if(! isset(static::$resources[$name]))
        {
            throw new TypeNotFoundException("Type $name not found");
        }

        return static::$resources[$name]->toGraphType();
    }

    protected function toGraphType(array $objectTypes)
    {
        return collect($objectTypes)->map(function ($object,$key){
            return [$object->name() => $object->toGraphType()];
            })->all();
    }

    public function query(string $query){

       $this->executeQuery(
           new Schema(['query']),
           new Document($query));




        //return $this->queryAndReturnResults($query);
    }

    protected function queryAndReturnResults(string $query)
    {
        $scheme = $this->schema();
        return GraphQL::executeQuery($scheme,$query,null);
    }

    public function executeQuery(Schema $schema,Document $document)
    {
        switch($document->getOperation())
        {
            case 'query':

                break;
            case 'mutation':

                break;
            case 'subscription':

                break;
            case 'introspection':

                break;
        }
    }

}
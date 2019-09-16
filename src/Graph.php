<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 26/08/2018
 * Time: 13:53
 */

namespace Tools4Schools\Graph;

use GraphQL\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;
use ReflectionClass;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class Graph
{
    /**
     * The registered resource names.
     *
     * @var array
     */
    public static $resources = [];


    /**
     * Get the current Graph version.
     *
     * @return string
     */
    public static function version()
    {
        return '0.0.3';
    }



    public static function path()
    {
        return config('graph.path','/graph');
    }


    /**
     * run a graphquery
     * @param $query
     * @return \GraphQL\Executor\ExecutionResult
     */
    public static function query($query)
    {
        return GraphQL::executeQuery(static::Schema(),$query);
    }

    /**
     * load a graphql compatible schema from our registered resources
     */
    public static function Schema()
    {
        $queries = ['name'=>'Query','fields'=>[]];
        $mutations = ['name'=>'Mutations','fields'=>[]];

        foreach (static::$resources as $type){


           array_pull($queries['fields'],(new $type())->getQueries());

           //array_pull($mutations['fields'],(new $type())->getMutations());
        }

        return new Schema(['query'=>new ObjectType($queries),'mutation'=>new ObjectType($mutations)]);
    }

    /**
     * Register the given reources
     *
     * @param array $resources
     * @return Graph
     */
    public static function resources(array $resources)
    {
        static::$resources = array_merge(static::$resources,$resources);

        return new static;
    }

    /**
     * Register all of the resource classes in the given directory.
     *
     * @param $directory
     * @return void
     */
    public static function resourcesIn($directory)
    {
        $namespace = app()->getNamespace();

        $resources = [];

        foreach ((new Finder)->in($directory)->files() as $resource) {
            $resource = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($resource->getPathname(), app_path().DIRECTORY_SEPARATOR)
                );

            if (is_subclass_of($resource, GraphResource::class) &&
                ! (new ReflectionClass($resource))->isAbstract()) {
                $resources[] = $resource;
            }
        }

        static::resources(
            collect($resources)->sort()->all()
        );
    }

    /**
     * Get the resource class name for a given key
     *
     * @param $key
     * @return mixed
     */
    public static function resourceForKey($key)
    {
        return collect(static::$resources)->first(function ($value) use ($key) {
            return $value::uriKey() === $key;
        });
    }
}
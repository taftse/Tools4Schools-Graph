<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 26/08/2018
 * Time: 13:53
 */

namespace Tools4Schools\Graph;


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
    public static function resourceIn($directory)
    {
        $namespace = app()->getNamespace();

        $resources = [];

        foreach ((New Finder)->in($directory)->files() as $resource){
            $resource = $namespace.str_replace(
                ['/','.php'],
                ['\\',''],
                Str::after($resource->getPathname(),app_path().DIRECTORY_SEPARATOR)
                );
            if(is_subclass_of($resource,Resource::class) && !(new ReflectionClass($resource))->isAbstract())
            {
                $resources[] = $resource;
            }
        }

        static::resources(collect($resources)->sort()->all());
    }
}
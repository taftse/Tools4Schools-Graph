<?php


namespace Tools4Schools\Graph;


use ReflectionClass;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class GraphServer
{
    /**
     * The registered resource names. (Types Definitions)
     *
     * @var array
     */
    public static $resources = [];


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
        $namespace = app()->getNamespace();

        $resources = [];

        foreach ((new Finder())->in($directory)->files() as $resources){
            $resource = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($resource->getPathname(), app_path().DIRECTORY_SEPARATOR)
                );
            if(is_subclass_of($resource, Resource::class) &&
                ! (new ReflectionClass($resource))->isAbstract()) {
                $resources[] = $resource;
            }
        }

        static::resources(
            collect($resources)->sort()->all()
        );
    }
}
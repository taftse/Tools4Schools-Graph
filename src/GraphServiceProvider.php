<?php

namespace Tools4Schools\Graph;

use Illuminate\Support\ServiceProvider;
use Tools4Schools\Graph\Console\ResourceMakeCommand;

class GraphServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->resourcesIn('app\Graph');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerResourceMakeCommand();


    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerResourceMakeCommand()
    {
        $this->app->singleton('command.graph.resource', function ($app) {
            return new ResourceMakeCommand($app['files']);
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                'command.graph.resource',
            ]);
        }
    }


    protected function resourcesIn($path = 'app\Graph')
    {
        foreach (scandir (base_path($path)) as $file)
        {
            if(strpos($file, '.php') && $file != "Resource.php")
            {

               $namespace = $this->get_class_from_file(base_path($path).'\\'.$file);
               $this->resource($namespace);
            }
        }
    }

    protected function resource($class)
    {
        //echo strtolower(substr(strrchr($class, "\\"), 1));
       return $this->app['router']->apiResource(strtolower(substr(strrchr($class, "\\"), 1)),$class);
    }

    function get_class_from_file($path_to_file)
    {
        //Grab the contents of the file
        $contents = file_get_contents($path_to_file);

        //Start with a blank namespace and class
        $namespace = $class = "";

        //Set helper values to know that we have found the namespace/class token and need to collect the string values after them
        $getting_namespace = $getting_class = false;

        //Go through each token and evaluate it as necessary
        foreach (token_get_all($contents) as $token) {

            //If this token is the namespace declaring, then flag that the next tokens will be the namespace name
            if (is_array($token) && $token[0] == T_NAMESPACE) {
                $getting_namespace = true;
            }

            //If this token is the class declaring, then flag that the next tokens will be the class name
            if (is_array($token) && $token[0] == T_CLASS) {
                $getting_class = true;
            }

            //While we're grabbing the namespace name...
            if ($getting_namespace === true) {

                //If the token is a string or the namespace separator...
                if(is_array($token) && in_array($token[0], [T_STRING, T_NS_SEPARATOR])) {

                    //Append the token's value to the name of the namespace
                    $namespace .= $token[1];

                }
                else if ($token === ';') {

                    //If the token is the semicolon, then we're done with the namespace declaration
                    $getting_namespace = false;

                }
            }

            //While we're grabbing the class name...
            if ($getting_class === true) {

                //If the token is a string, it's the name of the class
                if(is_array($token) && $token[0] == T_STRING) {

                    //Store the token's value as the class name
                    $class = $token[1];

                    //Got what we need, stope here
                    break;
                }
            }
        }

        //Build the fully-qualified class name and return it
        return $namespace ? $namespace . '\\' . $class : $class;

    }
}

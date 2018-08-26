<?php

namespace Tools4Schools\Graph;


use Illuminate\Support\Facades\Route;
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

        $this->registerRoutes();

        //$this->resourcesIn('app\Graph');
    }


    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/graph.php');
        });
    }

    /**
     * Get the Nova route group configuration array.
     *
     * @return array
     */
    protected function routeConfiguration()
    {
        return [
            'namespace' => 'Tools4Schools\Graph\Http\Controllers',
            'as' => 'graph.api.',
            'prefix' => 'graph-api',
            'middleware' => 'graph',
        ];
    }


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->registerResourceMakeCommand();
        $this->commands([
            Console\ResourceMakeCommand::class,
            Console\FilterMakeCommand::class
        ]);

    }
}

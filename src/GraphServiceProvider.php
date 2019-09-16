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
        // register the service providers
       /* $this->publishes([
            __DIR__.'/Console/stubs/GraphServiceProvider.stub' => app_path('Providers/GraphServiceProvider.php'),
        ], 'graph-provider');
*/

        $this->registerRoutes();
        $this->resources();


        //Graph::resourcesIn(app_path('Graph'));
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
            'prefix' => 'graph',
           // 'middleware' => 'graph',
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
     /*   $this->commands([
            Console\InstallCommand::class,
            Console\ResourceMakeCommand::class,
            Console\FilterMakeCommand::class
        ]);*/

    }

    /**
     * Register the application's Graph resources.
     *
     * @return void
     */
    protected function resources()
    {
        Graph::resourcesIn(app_path('Graph'));
    }
}

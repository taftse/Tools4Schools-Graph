<?php

namespace Tools4Schools\Graph;


use Illuminate\Container\Container;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Tools4Schools\Graph\Console\ResourceMakeCommand;
use Tools4Schools\Graph\Resolvers\EloquentResolver;

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




        //Graph::resourcesIn(app_path('Graph'));
    }


    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {


        Route::middleware(config('graph.middleware',[]))
            ->domain(config('graph.domain',null))
            ->group(function (){
                Route::get(GraphServer::path(),'Tools4Schools\Graph\Http\Controllers\GraphController@handle');
                Route::post(GraphServer::path(),'Tools4Schools\Graph\Http\Controllers\GraphController@handle');
            });
    }


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->singleton(GraphServer::class);

        //$this->registerResourceMakeCommand();
     /*   $this->commands([
            Console\InstallCommand::class,
            Console\ResourceMakeCommand::class,
            Console\FilterMakeCommand::class
        ]);*/

     $this->app->singleton('graphserver',function(Container $app):GraphServer{
         return new GraphServer();
     });

        //$this->app['graphserver']->registerResolver(new EloquentResolver());
        $this->registerTypes();
        $this->registerQueries();
        $this->registerMutations();

    }

    /**
     * Register the application's Graph resources.
     *
     * @return void
     */
    protected function registerTypes()
    {
       $this->app['graphserver']->typesIn(app_path('Graph\Types'));
    }

    /**
     * Register the application's Graph Mutations.
     *
     * @return void
     */
    protected function registerMutations()
    {
        $this->app['graphserver']->typesIn(app_path('Graph\Mutations'));
    }

    /**
     * Register the application's Graph Queries.
     *
     * @return void
     */
    protected function registerQueries()
    {
        $this->app['graphserver']->typesIn(app_path('Graph\Queries'));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['graphserver'];
    }
}

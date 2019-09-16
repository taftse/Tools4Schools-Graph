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
        Route::middleware('graph.middleware',[])
            ->domain('graph.domain',null)
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
        GraphServer::resourcesIn(app_path('Graph'));
    }
}

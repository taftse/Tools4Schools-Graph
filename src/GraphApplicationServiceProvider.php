<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tools4Schools\Graph\Graph;

class GraphApplicationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes();
        //Graph::serving(function(ServingGraph $event){
            //$this->authorization();
            $this->resources();
        //})
    }


    /**
     * Register the Graph routes
     *
     * return void
     */
    protected function routes()
    {
        Graph::routes();
    }


    protected function resources(){
        Graph::resourceIn(app_path('Graph'));
    }


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


}

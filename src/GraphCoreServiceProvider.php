<?php

namespace Tools4Schools\Graph;

use Illuminate\Support\ServiceProvider;

class GraphCoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->runningInConsole()){
            $this->app->register(GraphServiceProvider::class);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

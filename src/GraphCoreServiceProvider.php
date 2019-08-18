<?php

namespace Tools4Schools\Graph;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Tools4Schools\Graph\Http\Middleware\ServeGraphRequests;

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

        $this->app->make(HttpKernel::class)->pushMiddleware(ServeGraphRequests::class);
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

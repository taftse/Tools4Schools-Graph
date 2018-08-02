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
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerResourceMakeCommand();

        if ($this->app->runningInConsole()) {
            $this->commands([
                'command.graph.resource',
            ]);
        }
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
    }
}

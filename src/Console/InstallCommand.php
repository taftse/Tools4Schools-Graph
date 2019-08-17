<?php

namespace Tools4Schools\Graph\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'graph:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the required Graph Resources';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Publishing Graph Service Provider...');
        $this->callSilent('vendor:publish',['--tag'=>'graph-provider']);

        $this->registerGraphServiceProvider();

        $this->comment('Generating User Resource...');
        $this->callSilent('graph:resource',['name','User']);

    }

    protected function registerGraphServiceProvider()
    {
        file_put_contents(config_path('app.php'),str_replace(
            "/*
         * Package Service Providers...
         */",
            "/*
         * Package Service Providers...
         */        App\Providers\GraphServiceProvider::class,".PHP_EOL,
            file_get_contents(config_path('app.php'))
        ));
    }
}

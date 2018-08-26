<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 08/08/2018
 * Time: 22:56
 */

namespace Tools4Schools\Graph\Console;

use Illuminate\Console\GeneratorCommand;


class FilterMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'graph:filter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new filter class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Filter';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
       $stub = '/stubs/filter.stub';

        return __DIR__.$stub;
    }
}
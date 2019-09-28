<?php


namespace Tools4Schools\Graph\Support\Facades;


use Illuminate\Support\Facades\Facade;

/**
 * Class GraphServer
 * @package Tools4Schools\Graph\Support\Facades
 *
 * @method static array query(string $query)
 *
 */
class GraphServer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'graphserver';
    }
}
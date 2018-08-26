<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 26/08/2018
 * Time: 13:53
 */

namespace Tools4Schools\Graph;


use Symfony\Component\Finder\Finder;

class Graph
{
    /**
     * The registered resource names.
     *
     * @var array
     */
    public static $resources = [];


    /**
     * Get the current Graph version.
     *
     * @return string
     */
    public static function version()
    {
        return '0.0.3';
    }



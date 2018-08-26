<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 08/08/2018
 * Time: 22:49
 */

namespace Tools4Schools\Graph\Filters;


use Illuminate\Http\Request;

class Filter
{

    /**
     * Apply the filter to the given query
     *
     * @param Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request,$query,$value)
    {
        return $query;
    }

    /**
     * Get the filter's available options
     */
    public function options()
    {
        return [];
    }
}
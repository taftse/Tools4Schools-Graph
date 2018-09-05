<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 02/09/2018
 * Time: 17:32
 */

namespace Tools4Schools\Graph;



use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

trait Authorizable
{
    /**
     * Determine if the given resource is authorizable.
     *
     * @return bool
     */
    public static function authorizable()
    {
        return ! is_null(Gate::getPolicyFor(static::newModel()));
    }


    /**
     * Determine if the resource should be available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizeToViewAny(Request $request)
    {
        if (! static::authorizable()) {
            return;
        }

        if (method_exists(Gate::getPolicyFor(static::newModel()), 'viewAny')) {
            $this->authorizeTo($request, 'viewAny');
        }
    }

    /**
     * Determine if the resource should be available for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function authorizedToViewAny(Request $request)
    {
        if (! static::authorizable()) {
            return true;
        }

        return method_exists(Gate::getPolicyFor(static::newModel()), 'viewAny')
            ? Gate::check('viewAny', get_class(static::newModel()))
            : true;
    }

    /**
     * Determine if the current user has a given ability.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $ability
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorizeTo(Request $request,$ability)
    {
        throw_unless($this->authorizedTo($request, $ability), AuthorizationException::class);
    }

    /**
     * Determine if the current user can view the given resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $ability
     * @return bool
     */
    public function authorizedTo(Request $request, $ability)
    {
        return static::authorizable() ? Gate::check($ability,$this->resource) : true;
    }
}
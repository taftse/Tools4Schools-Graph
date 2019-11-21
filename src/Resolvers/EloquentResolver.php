<?php


namespace Tools4Schools\Graph\Resolvers;


use Tools4Schools\Graph\Contracts\Resolver;

class EloquentResolver implements Resolver
{
    public function name(): string
    {
        return 'Eloquent';
    }
}
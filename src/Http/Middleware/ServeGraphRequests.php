<?php


namespace Tools4Schools\Graph\Http\Middleware;


use Tools4Schools\Graph\Graph;
use Tools4Schools\Graph\GraphServiceProvider;

class ServeGraphRequests
{

    public function handle($request,$next){
        if($this->isGraphRequest($request)){
            app()->register(GraphServiceProvider::class);
        }

        return $next($request);
    }

    protected function isGraphRequest($request){
        $path = trim(Graph::path(),'/')?: '/';

        return $request->is($path)||
               $request->is('graph');
    }

}
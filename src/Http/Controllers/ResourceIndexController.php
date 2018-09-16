<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 26/08/2018
 * Time: 12:01
 */

namespace Tools4Schools\Graph\Http\Controllers;

use Tools4Schools\Graph\Graph;
use Illuminate\Routing\Controller;
use Tools4Schools\Graph\Http\Requests\ResourceIndexRequest;

class ResourceIndexController extends Controller
{
    public function handle(ResourceIndexRequest $request)
    {

        $paginator = $this->paginator(
            $request, $resource = $request->resource()
        );
    }


    protected function paginator(ResourceIndexRequest $request,$resource)
    {
        dd($request->toQuery());
    }
}
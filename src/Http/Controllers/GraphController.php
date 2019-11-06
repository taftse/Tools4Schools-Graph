<?php


namespace Tools4Schools\Graph\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tools4Schools\Graph\Support\Facades\GraphServer;


class GraphController extends Controller
{
    public function handle(Request $request)//: JsonResponse
    {
        if (!$request->has('query')) {
            return response()->json(['data' => ['hello' => "Your GraphQL endpoint is ready! Install GraphiQL to browse API"]]);
        }

        $query = $request->get('query');
        $variables = $request->get('variables');
        $operationName = $request->get('operationName');
        return GraphServer::query($query,$operationName,$variables);

    }
}
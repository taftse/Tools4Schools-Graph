<?php

namespace Tools4Schools\Graph\Response;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\HTTP\Resources\Json\JsonResource;
use Tools4Schools\Graph\Resource;

class Response implements Responsable
{
    
    public function __construct(Resource $resource)
    {
    	$this->resource = $resource;//= $resourceType;
    }

    /*public function setResource($resource)
    {
    	parent::__construct($resource);
    	return $this;
    }*/

    public function toArray($request)
    {
    	return[
    		'type' => '',//$this->resourceType,
    		'id' => '',//$this->id,
    		'attributes'=> '',//$this->getFields(),
    		'relationships' =>'',
    		'link' =>[
    			'self' => route('user.show',['user' =>''/*$this->id*/]),
    		],
    	];	
    }
	/**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function toResponse($request)
	{
		/*return tap(response()->json(
				$this->resource->resolve($request)
		),function($response) use ($request){
			
		}*/
	} 
	//*/
}
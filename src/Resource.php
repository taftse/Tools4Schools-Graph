<?php

namespace Tools4Schools\Graph;


use Illuminate\Http\Request;
use Tools4Schools\Graph\Response\Response;
use Illuminate\Validation\ValidationException;
use Tools4Schools\Graph\Response\ResponseCollection;

abstract class Resource 
{
	/**
	 * The model the resource corresponds to.
	 *
	 * @var string
	 */
	public static $model = '';

	/**
	 * The single value that should be used to represent the resource when being displayed
	 *
	 * @var string
	 */
	public static $title ='name';

    protected $response;


    /**
     * Get the fields returned by the resource
     *
     * @param Request $request
     * @return mixed
     */
	public abstract function fields(Request $request);

    public function __construct(Request $request)
    {
        $this->request = $request;
        //$this->response = new Response($this);
    }//*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->newQuery($this->getFields(true))->paginate();
        // return new ResponseCollection($query->paginate());
       //return $query->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->validate($this->getCreateValidator());
        }
        catch(ValidationException $e)
        {
            return response()->json([
                    'error'=>[
                        'message'=>$e->errors()
                    ]
                ],422);
        }


        $resource = $this->model($request->all());
        $resource->save();

       return  response()->json(['id'=>$resource->id],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->newQuery($this->getFields())->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       try{
            $request->validate($this->getUpdateValidator());
        }
        catch(ValidationException $e)
        {
            return response()->json([
                    'error'=>[
                        'message'=>$e->errors()
                    ]
                ],422);
        }


        $resource = $this->model()->find($id);
        $resource->update($request->all());

       return  response()->json(['id'=>$resource->id],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function getFields($index = false)
    {
        $fields = [];
        foreach ($this->fields($this->request) as $field) {
            if($field->hideFromIndex != true)
            {
                $fields[] = $field->name();
            }
        }
        return $fields;
    }

    protected function model(array $attributes = [])
    {
        return new static::$model($attributes);
    }

    protected function newQuery($fields = ['*'])
    {
        return $this->model()->select($fields);
    }

    public function getUpdateValidator()
    {
        $rules = [];
        foreach ($this->fields($this->request) as $field) {
            $rules = array_merge($rules,$field->getUpdateRules());
        }
        return $rules;

    }

    public function getCreateValidator()
    {
        $rules = [];
        foreach ($this->fields($this->request) as $field) {
            $rules = array_merge($rules,$field->getUpdateRules());
        }
        return $rules;

    }
}
<?php

namespace Tools4Schools\Graph;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


abstract class Resource //extends JsonResource
{
    use Authorizable;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public $model;

    /**
     * The single value that should be used to represent the resource when being displayed
     *
     * @var string
     */
    public static $title = 'id';


    /**
     * The relationships that should be eager loaded when preforming an index query
     *
     * @var array
     */
     public static $with = [];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [];


    /**
     * Indicates if the resource should be globally searchable
     *
     * @var bool
     */

    public static $globallySearchable = false;

    /**
     * Create a new resource instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get the fields returned by the resource
     *
     * @param Request $request
     * @return mixed
     */
    public abstract function fields(Request $request);



    /**
     * Get the underlying model instance for the resource.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function model()
    {
        return $this->model;
    }


    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->{static::$title};
    }

    /**
     * Get the search result subtitle for the resource.
     *
     * @return string
     */
    public function subtitle()
    {
        return null;
    }

    /**
     * Get a fresh instance of the model represented by the resource.
     *
     * @return mixed
     */
    public static function newModel()
    {
        $model = static::$model;

        return new $model;
    }

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return Str::plural(Str::snake(class_basename(get_called_class()), '-'));
    }










    //---------------------------------------------------------------------------------------------------

    protected $response;





    /**
     * Get the filters available for the resource
     *
     * @param Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }


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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate($this->getCreateValidator());
        } catch (ValidationException $e) {
            return response()->json([
                'error' => [
                    'message' => $e->errors()
                ]
            ], 422);
        }


        $resource = $this->model($request->all());
        $resource->save();

        return response()->json(['id' => $resource->id], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->newQuery($this->getFields())->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate($this->getUpdateValidator());
        } catch (ValidationException $e) {
            return response()->json([
                'error' => [
                    'message' => $e->errors()
                ]
            ], 422);
        }


        $resource = $this->model()->find($id);
        $resource->update($request->all());

        return response()->json(['id' => $resource->id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get the fields displayed by the resource
     *
     * @param bool $index
     * @return array
     */

    protected function getFields($index = false)
    {
        $fields = [];
        foreach ($this->fields($this->request) as $field) {
            if ($field->hideFromIndex != true) {
                $fields[] = $field->name();
            }
        }
        return $fields;
    }



    protected function newQuery($fields = ['*'])
    {
        return $this->model()->select($fields);
    }

    public function getUpdateValidator()
    {
        $rules = [];
        foreach ($this->fields($this->request) as $field) {
            $rules = array_merge($rules, $field->getUpdateRules());
        }
        return $rules;

    }

    public function getCreateValidator()
    {
        $rules = [];
        foreach ($this->fields($this->request) as $field) {
            $rules = array_merge($rules, $field->getUpdateRules());
        }
        return $rules;

    }
}
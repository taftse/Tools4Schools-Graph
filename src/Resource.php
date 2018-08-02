<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 31/07/2018
 * Time: 15:59
 */

namespace Tools4Schools\Graph;


use Illuminate\Http\Request;

class Resource
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


    /**
     * Get the fields returned by the resource
     *
     * @param Request $request
     * @return mixed
     */
	public abstract  function fields(Request $request);


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function put(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request,$id)
    {
        //
    }
}
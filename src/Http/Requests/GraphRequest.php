<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 26/08/2018
 * Time: 12:06
 */

namespace Tools4Schools\Graph\Http\Requests;

use Tools4Schools\Graph\Graph;

use Illuminate\Foundation\Http\FormRequest;

class GraphRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function resource()
    {
        return tap(Graph::resourceForKey($this->resource),function($resource){
            abort_if(is_null($resource),404);
            abort_if(!$resource::authorizedToViewAny($this),403);
        });
    }


    public function model(){
        $resourcec = $this->resource();

        return $resourcec::newModel();
    }

}
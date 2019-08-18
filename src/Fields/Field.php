<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 31/07/2018
 * Time: 16:35
 */

namespace Tools4Schools\Graph\Fields;

class Field
{
    /**
     * Display name of the field
     *
     * @var string
     */
    protected $displayName;

    /**
     * Field name
     *
     * @var string
     */
    protected $fieldName;

    /**
     * The field's resolved value.
     *
     * @var mixed
     */
    public $value;





    /**
     * The creation and update Rules
     *
     * @var array
     */
    protected $rules = ['creation'=>[],'update'=>[]];



    public function __construct(String $displayName,String $fieldName = null,Closure $format)
    {
        $this->displayName = $displayName;
        $this->fieldName = $fieldName?? str_replace(' ','_',Str::lower($displayName));
    }

    public static function make($displayName = '',$fieldName,Closure $format)
    {
        return new self($displayName,$fieldName,$format);
    }

    public function name()
    {
        return $this->name;
    }


    public function rules(...$rules)
    {
        $theRule = '';
        foreach ($rules as $rule) {
            if($theRule != '')
            {
               $theRule = $theRule.'|';
            }
            $theRule = $theRule.$rule;
        }
            $this->rules['creation'][strtolower($this->name)] = $theRule;
            $this->rules['update'][strtolower($this->name)] = $theRule;
        return $this;
    }

    public function creationRules(... $rules)
    {
       $theRule = '';
        foreach ($rules as $rule) {
            if($theRule != '')
            {
               $theRule = $theRule.'|';
            }
            $theRule = $theRule.$rule;
        }
            $this->rules['creation'][strtolower($this->name)] = $theRule;
        
        return $this;
    }

    public function getCreationRules()
    {
        return $this->rules['creation'];
    }

    public function updateRules(...$rules)
    {
      $theRule = '';
        foreach ($rules as $rule) {
            if($theRule != '')
            {
               $theRule = $theRule.'|';
            }
            $theRule = $theRule.$rule;
        }
        $this->rules['update'][strtolower($this->name)] = $theRule;

        return $this;
    }

    public function getUpdateRules()
    {
        return $this->rules['update'];
    }


}
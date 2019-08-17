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
     * Should this field be hidden from the index request
     *
     * @var bool
     */
    public $hideFromIndex = false;

    /**
     * The creation and update Rules
     *
     * @var array
     */
    protected $rules = ['creation'=>[],'update'=>[]];



    public function __construct($displayName,$fieldName,Closure $format)
    {
        $this->displayName = $displayName;
        $this->fieldName = $fieldName;
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

    public function hideFromIndex()
    {
        $this->hideFromIndex = true;
        return $this;
    }

    public function searchable()
    {
        return $this;
    }
}
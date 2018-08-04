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
     * Name of the field
     *
     * @var string
     */
    protected $name;

    public $hideFromIndex = false;

    protected $rules = ['creation'=>[],'update'=>[]];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function make($name = '')
    {
        return new self($name);
    }

    public function name()
    {
        return $this->name;
    }

    public function sortable()
    {
        return $this;
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
}
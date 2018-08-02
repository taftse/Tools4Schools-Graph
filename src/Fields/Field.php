<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 31/07/2018
 * Time: 16:35
 */

namespace Tools4Schools\Graph\Fields;


abstract class Field
{
    /**
     * Name of the field
     *
     * @var string
     */
    protected $name;

    public function make($name)
    {
        $this->name = $name;
        return $this;
    }

    public function sortable()
    {
        return $this;
    }

    public function rules(...$rules)
    {
        return $this;
    }

    public function creationRules(... $rules)
    {
        return $this;
    }

    public function updateRules(...$rules)
    {
        return $this;
    }

    public function hideFromIndex(... $rules)
    {

    }
}
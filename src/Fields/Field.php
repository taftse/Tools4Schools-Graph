<?php


namespace Tools4Schools\Graph\Fields;


abstract class Field
{

    protected $name;



    public function __construct(string $name,string $attribute = null,$resolveCallback = null)
    {
        $this->name = $name;
    }

    public function resolve($resource,$attribute = null):void
    {

    }




    /***
     * From Laravel\Nova\Element .php
     */

    /**
     * Create a new element.
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }
}
<?php


namespace Tools4Schools\Graph;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ScalarType;

abstract class GraphElement
{
    /**
     * The name of the element.
     *
     * @var string
     */
    public $name;

    /**
     * A description of the element
     *
     * @var string
     */
    public $description;

    /**
     * The type of object that is returned
     *
     * @return mixed
     */
    abstract public function type();


    /**
     * converts this object to an array
     *
     * @return array
     */
    public function toArray()
    {
        return ['name'=>$this->name(),'type'=>$this->type()];
    }


    public function toGraphObject():array
    {
        if($this->type() instanceof ScalarType)
        {
            return [$this->name()=>$this->type()];
        }

        return [$this->name()=> new ObjectType($this->toArray())];
    }


    public function name():string
    {
        if($this->name != '')
        {
            return $this->name;
        }

        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * Create a new GraphElement.
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

}
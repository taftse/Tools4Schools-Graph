<?php


namespace Tools4Schools\Graph;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ScalarType;

abstract class BaseType
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
     * is this a required field and as such should it always be returned
     *
     * @var bool
     */
    public $required = false;

    /**
     * is this a deprecated field
     *
     * @var bool
     */
    public $deprecated = false;

    /**
     * the resolved value of this type
     *
     * @var
     */
    public $value;


    public function __construct(string $name = '')
    {
        $this->name = $name;
        return $this;
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

    /**
     * Marks this as a required imput
     *
     * @return $this
     */
    public function required()
    {
        $this->required = true;
        return $this;
    }

    /**
     * Marks this as a required imput
     *
     * @return $this
     */
    public function deprecated()
    {
        $this->deprecated = true;
        return $this;
    }


    abstract public function resolve($selectionSet,BaseType $parent = null);
}
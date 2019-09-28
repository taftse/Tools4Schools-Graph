<?php


namespace Tools4Schools\Graph;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type as GraphqlType;
use Illuminate\Http\Request;

abstract class Resource
{

    public static $name;

    public static $description ='';




    abstract public function fields();

    //abstract public function


    public function getAttributes(){
        $attributes['name'] = $this->name();
        $attributes['description'] = static::$description;
        $attributes['fields'] = $this->getFields();

        return $attributes;
    }

    public function toArray(): array
    {
        return $this->getAttributes();
    }

    public function toGraphType(): GraphqlType
    {
        return new ObjectType($this->toArray());
    }

    public function getFields()
    {
        $fields = [];

        foreach ($this->fields() as $field)
        {
            $fields = $fields + $field->toGraphObject();
        }
        return $fields;
    }

    public function name():string
    {

        if(static::$name != '')
        {
            return static::$name;
        }

        return (new \ReflectionClass($this))->getShortName();
    }
}
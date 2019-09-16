<?php


namespace Tools4Schools\Graph;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type as GraphqlType;
use Illuminate\Http\Request;

abstract class Resource
{

    public static $name ='';

    public static $description ='';

    abstract public function fields();



    public function getFields(){
        return $this->fields();
    }


    public function getAttributes(){
        $attributes['name'] = static::$name;
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
}
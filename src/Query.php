<?php


namespace Tools4Schools\Graph;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type as GraphqlType;

abstract class Query
{
    /**
     * @var string
     */
    protected static $name ='';


    /**
     * @var string
     */

    public static $description ='';

    /**
     * @return array
     */

    abstract protected function type();

    public function fields()
    {
        $type = $this->type();
        return (new $type)->toGraphType();
    }

    /**
     * @return Type
     */
    public function getType():GraphqlType
    {
        return GraphqlType::listOf(GraphServer::type($this->type()));
    }

    /**
     * @return array
     */
    public function getAttributes():array
    {
        $attributes['name'] = $this->name();
        $attributes['description'] = static::$description;
        $attributes['fields'] = $this->fields();
        $attributes['type'] = $this->getType();

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

    public function name():string
    {
        if(static::$name != '')
        {
            return static::$name;
        }

        return (new \ReflectionClass($this))->getShortName();
    }
}
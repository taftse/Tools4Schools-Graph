<?php


namespace Tools4Schools\Graph;


use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type as GraphqlType;
use ReflectionClass;
use Tools4Schools\Graph\Types\GraphType;

abstract class Query extends GraphType
{


    protected function args() : array
    {
        return [];
    }


    public function resolver($root = null,$args=null)
    {
        return function (){return 'hello world';};
    }






















    /**
     * @return array
     */

    abstract protected function type();


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
        $attributes['description'] = $this->description;
        $attributes['type'] = $this->getType();
        $attributes['resolve'] = $this->resolver();
        $attributes['args'] = $this->args();

        return $attributes;
    }

    public function toArray(): array
    {
        return $this->getAttributes();
    }

    public function toGraphType()//: GraphqlType
    {
        return $this->toArray();
        //return new ObjectType($this->toArray());
    }
}
<?php
namespace Tools4Schools\Graph\Fields;



use GraphQL\Type\Definition\Type as GraphqlType;
use Tools4Schools\Graph\GraphElement;

abstract class Field extends GraphElement
{

    public function __construct(string $name,string $attribute = null,$resolveCallback = null)
    {
        $this->name = $name;
    }

    protected function args():array
    {
        return [];
    }


    public function resolve($resource,$attribute = null):void
    {

    }

}
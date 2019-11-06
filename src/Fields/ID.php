<?php


namespace Tools4Schools\Graph\Fields;


use GraphQL\Type\Definition\Type;

class ID extends Field
{


    public function type(){
        return 'ID';
    }


    public function __construct(string $name = null, string $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name ?? 'ID', $attribute, $resolveCallback);
    }


}
<?php


namespace Tools4Schools\Graph\Fields;


use GraphQL\Type\Definition\Type;
use Tools4Schools\Graph\Types\ScalarType;

class ID extends ScalarType
{
    public function type(){
        return 'ID';
    }

    public function __construct(string $name = null)
    {
        parent::__construct($name ?? 'ID');
    }


}
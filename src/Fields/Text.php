<?php


namespace Tools4Schools\Graph\Fields;


use GraphQL\Type\Definition\Type;
use Tools4Schools\Graph\Types\ScalarType;

class Text extends ScalarType
{
    public function type(){
        return 'String';
    }
}
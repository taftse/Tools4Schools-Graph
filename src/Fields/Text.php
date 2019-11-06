<?php


namespace Tools4Schools\Graph\Fields;


use GraphQL\Type\Definition\Type;

class Text extends Field
{
    public function type(){
        return 'String';
    }
}
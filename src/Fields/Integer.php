<?php


namespace Tools4Schools\Graph\Fields;


use Tools4Schools\Graph\Types\ScalarType;

class Integer extends ScalarType
{
    public function type()
    {
        return 'Int';
    }
}
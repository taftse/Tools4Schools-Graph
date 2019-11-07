<?php


namespace Tools4Schools\Graph\Fields;

// returns a single object
use Tools4Schools\Graph\Types\ListType;

class HasOne extends RelationField
{
    public function type()
    {
        return new ListType();
    }
}
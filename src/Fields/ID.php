<?php


namespace Tools4Schools\Graph\Fields;


use GraphQL\Type\Definition\Type;
use Tools4Schools\Graph\Schema\Types\ScalarType;

class ID extends ScalarType
{
    public function __construct(string $name = null)
    {
        parent::__construct($name ?? 'ID');
    }
}
<?php


namespace Tools4Schools\Graph\Language\AST\Types;


use Tools4Schools\Graph\Contracts\Types\InputType;
use Tools4Schools\Graph\Contracts\Types\OutputType;
use Tools4Schools\Graph\Contracts\Request\Types\NamedType;
use Tools4Schools\Graph\Language\AST\Location;

class ScalarType extends Type implements InputType,OutputType,NamedType
{
    protected $value = null;

    public function __construct($value,Location $location)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}
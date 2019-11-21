<?php


namespace Tools4Schools\Graph\Language\AST\Types;


use Tools4Schools\Graph\Contracts\Request\Location;
use Tools4Schools\Graph\Contracts\Types\InputType;
use Tools4Schools\Graph\Contracts\Types\OutputType;
use Tools4Schools\Graph\Contracts\Request\Types\NamedType;

class EnumType extends Type implements InputType,OutputType,NamedType
{
    protected $value = null;

    public function __construct($value,Location $location)
    {
        $this->value = $value;
        parent::__construct($location);
    }

    public function value()
    {
        return $this->value;
    }
}
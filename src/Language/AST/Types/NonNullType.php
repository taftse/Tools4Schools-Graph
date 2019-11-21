<?php


namespace Tools4Schools\Graph\Language\AST\Types;


use Tools4Schools\Graph\Contracts\Request\Location;
use Tools4Schools\Graph\Contracts\Request\Types\Type as TypeContract;
use Tools4Schools\Graph\Contracts\Request\Types\WrapperType;

class NonNullType extends Type implements WrapperType
{
    protected $type;

    public function __construct(Type $type,Location $location)
    {
        $this->type = $type;
        parent::__construct($location);
    }

    public function type():TypeContract
    {
        return $this->type;
    }
}
<?php


namespace Tools4Schools\Graph\Language\AST\Types;


use Tools4Schools\Graph\Contracts\Request\Types\Type as TypeContract;
use Tools4Schools\Graph\Contracts\Request\Location;

abstract class Type implements TypeContract
{
    protected $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function location():Location
    {
        return $this->location;
    }
}
<?php


namespace Tools4Schools\Graph\Language\AST\Types;

use Tools4Schools\Graph\Contracts\Request\Location;
use Tools4Schools\Graph\Contracts\Request\Types\NamedType as NamedTypeContract;

class NamedType extends Type implements NamedTypeContract
{
    protected $type='';

    protected $required = false;

    public function __construct($type,Location $location)
    {
        $this->type = $type;
        parent::__construct($location);
    }

    public function type():string
    {
        return $this->type;
    }

    public function required()
    {
        $this->required = true;
        return $this;
    }

    public function isRequired()
    {
        return $this->required;
    }
}
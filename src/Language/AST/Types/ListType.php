<?php


namespace Tools4Schools\Graph\Language\AST\Types;


use Tools4Schools\Graph\Contracts\Request\Location;
use Tools4Schools\Graph\Contracts\Request\Types\WrapperType;
use Tools4Schools\Graph\Contracts\Request\Types\Type as TypeContract;


class ListType extends Type implements WrapperType
{
    protected $type;

    public function __construct(TypeContract $type,Location $location)
    {
        $this->type = $type;
        parent::__construct($location);
    }

    /**
     * {@inheritDoc}
     */
    public function type():Type
    {
        return $this->type;
    }


}
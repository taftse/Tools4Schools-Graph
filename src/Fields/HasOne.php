<?php


namespace Tools4Schools\Graph\Fields;

// returns a single object
use Tools4Schools\Graph\Contracts\Schema\Types\Type;
use Tools4Schools\Graph\Types\ListType;

class HasOne extends RelationField
{
    public function type()
    {
        return new $this->type;
    }

    public function __construct(Type $relationType, string $name = null, string $attribute = null, $resolveCallback = null)
    {
        $this->type = $relationType;
        parent::__construct($name, $attribute, $resolveCallback);
    }
}
<?php


namespace Tools4Schools\Graph\Fields;


use Tools4Schools\Graph\ObjectType;

class BelongsTo extends RelationField
{

    protected $type;

    public function type(){
        return $this->type;
    }

    public function __construct(ObjectType $relationType, string $name = null, string $attribute = null, $resolveCallback = null)
    {
        $this->type = $relationType;
        parent::__construct($name, $attribute, $resolveCallback);
    }

    // returns a single object
    public function resolve($resource, $attribute = null): void
    {
        // type.resolve(this)
    }
}
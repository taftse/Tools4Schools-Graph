<?php


namespace Tools4Schools\Graph\Fields;


use Tools4Schools\Graph\ObjectType;


//returns a collection of multiple objects
class HasMany extends RelationField
{
    protected $type;

    public function type(){
        return $this->type;
    }

    public function __construct(string $relationType, string $name = null, string $attribute = null, $resolveCallback = null)
    {
        $this->type = $relationType;
        parent::__construct($name, $attribute, $resolveCallback);
    }

    public function resolve($resource, $attribute = null): void
    {
        // type.resolve(this)
    }
}
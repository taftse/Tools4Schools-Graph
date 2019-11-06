<?php


namespace Tools4Schools\Graph\Fields;


use Tools4Schools\Graph\Type;

class BelongsTo extends Field
{

    protected $type;

    public function type(){
        return $this->type;
    }

    public function __construct(Type $relationType, string $name = null, string $attribute = null, $resolveCallback = null)
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
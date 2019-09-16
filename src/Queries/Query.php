<?php namespace Tools4Schools\Graph\Queries;




use Tools4Schools\Graph\GraphResource;

abstract  class Query
{
    /**
     * @var GraphResource
     */
    protected $resource;

    protected $arguments = [];

    protected $resolve;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function toArray()
    {
        return [$this->resource->getName() => ['type' => $this->resource->type(), 'resolve' => $this->resource->resolve()]];
    }
}
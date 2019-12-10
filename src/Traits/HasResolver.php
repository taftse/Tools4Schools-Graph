<?php


namespace Tools4Schools\Graph\Traits;


use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType;
use Tools4Schools\Graph\Contracts\Schema\Types\Type;

trait HasResolver
{
    protected $resolverCallback = null;

    /**
     * Set a resolver on this type
     *
     * @param callable|null $resolverCallback
     * @return Type
     */
    public function setResolver(?callable $resolverCallback):Type
    {
        $this->resolverCallback = $resolverCallback;

        return $this;
    }

    public function resolve(...$arguments)
    {

        if(!is_null($this->resolverCallback))
        {
            return call_user_func_array($this->resolverCallback,$arguments);
        }

        return $this->resolver($arguments[0],$arguments[1],$arguments[2],$arguments[3]);
    }


    //abstract protected function resolver(ObjectType $parent = null, array $arguments = [], $context = null, $info = null);

}
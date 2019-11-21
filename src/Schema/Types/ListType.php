<?php


namespace Tools4Schools\Graph\Schema\Types;


use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType as ObjectTypeContract;
use Tools4Schools\Graph\Schema\Types\ObjectType;

class ListType extends ObjectType
{
    protected $type;


    public function __construct(string $name,string $type)
    {
        $this->type = $type;
        parent::__construct($name);
    }

    public function fields(): array
    {
        // TODO: Implement fields() method.
    }

    public function resolve(ObjectTypeContract $parent = null, array $arguments = [], $context = null, $info = null)
    {
        $results =[];

       // dump($info->getName());
       // dump($parent->value[$info->getName()]);
        dump($info);

        foreach ($parent->value->{$info->getName()} as $field)
        {
            $this->value = $field;
            $results[] = (new $this->type)->resolve($this,$arguments,$context,$info);
        }









/*
        foreach($this->items as $item)
        {
            $results[] = $item->resolve($parent,$arguments,$context,$info);
        }*/
        return $results;
    }
}
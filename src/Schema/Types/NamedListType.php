<?php


namespace Tools4Schools\Graph\Schema\Types;


class NamedListType
{

    protected $type = '';
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    public function __construct(string $type)
    {
        $this->type = $type;
    }


    public function addItem($name,$item)
    {
        if (!$item instanceof $this->type) {
            throw new \Exception("The item being added is of type:".get_class($item)."  Expected type: ".$this->type);
        }
        $this->items[$name] = $item;
    }

    public function hasItem(string $itemName):bool
    {
        return isset($this->items[$itemName]);
    }

    public function getItem(string $itemName)
    {
        if(!$this->hasItem($itemName))
        {
            throw new \Exception("This list does not have a item named: ".$itemName);
        }
        return $this->items[$itemName];
    }

    public function resolve(Type $parent = null, array $arguments = [], $context = null, $info = null)
    {
        $results =[];
        foreach($this->items as $item)
        {
            $results[] = $item->resolve($parent,$arguments,$context,$info);
        }
        return $results;
    }
}
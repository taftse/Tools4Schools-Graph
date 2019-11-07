<?php


namespace Tools4Schools\Graph\Types;


use Tools4Schools\Graph\Contracts\Language\Schema\SDL\Node;

class ListType
{
    protected $type = '';
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    public function __construct(Node $type, $items = [])
    {
        $this->type = $type;
        $this->items = $items;
    }

    public function add($item)
    {
        if ($item instanceof $this->type) {
            $this->items[] = $item;
        }
        return this;
    }
}
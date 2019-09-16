<?php


namespace Tools4Schools\Graph\Fields;


class ID extends Field
{

    public function __construct(string $name, string $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name ?? 'ID', $attribute, $resolveCallback);
    }
}
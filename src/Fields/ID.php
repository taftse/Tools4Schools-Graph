<?php


namespace Tools4Schools\Graph\Fields;


class ID extends Field
{
    public function __construct($name = null)
    {
        parent::__construct($name ?? 'ID');
    }
}
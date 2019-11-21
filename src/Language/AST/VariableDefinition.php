<?php


namespace Tools4Schools\Graph\Language\AST;


use Tools4Schools\Graph\Contracts\Request\Types\WrapperType;
use Tools4Schools\Graph\Language\AST\Types\NonNullType;

class VariableDefinition
{

    protected $name;

    protected $type;

    public $defaultValue = null;

    public $location;

    public function __construct($name,$type,$defaultValue = null ,Location $location)
    {
        $this->name = $name;
        $this->type = $type;
        $this->defaultValue = $defaultValue;
        $this->location = $location;
    }

    public function name():string
    {
        return $this->name;
    }

    public function type()
    {
        return $this->type;
    }

    public function defaultValue()
    {
        return $this->defaultValue->value();
    }

}
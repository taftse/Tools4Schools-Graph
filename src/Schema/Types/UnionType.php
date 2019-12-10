<?php


namespace Tools4Schools\Graph\Schema\Types;


use Tools4Schools\Graph\Contracts\Schema\Types\AbstractType;
use Tools4Schools\Graph\Contracts\Types\OutputType;
use Tools4Schools\Graph\Traits\HasName;

abstract class UnionType implements OutputType,AbstractType
{
    use HasName;

    abstract protected function types():array;
}
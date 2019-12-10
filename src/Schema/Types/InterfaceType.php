<?php


namespace Tools4Schools\Graph\Schema\Types;



use Tools4Schools\Graph\Contracts\Schema\Types\AbstractType;
use Tools4Schools\Graph\Contracts\Types\OutputType;
use Tools4Schools\Graph\Contracts\Types\InterfaceType as InterfaceTypeContract;
use Tools4Schools\Graph\Traits\HasName;
use Tools4Schools\Graph\Traits\HasSelectionSet;

abstract class InterfaceType implements OutputType,AbstractType
{
    use HasName,HasSelectionSet;


    //abstract public function resolveType(InterfaceTypeContract $interface);
}
<?php


namespace Tools4Schools\Graph\Schema\Types;





use Tools4Schools\Graph\Contracts\Types\InputType;
use Tools4Schools\Graph\Contracts\Types\OutputType;
use Tools4Schools\Graph\Contracts\Schema\Types\EnumType as EnumTypeContract;
use Tools4Schools\Graph\Contracts\Schema\Types\Type as TypeContract;
use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType;

abstract class EnumType extends Type implements InputType,OutputType
{
    public function kind():TypeContract
    {
        return EnumTypeContract;
    }

    protected function resolver( ObjectType $parent = null, array $arguments = [], $context = null, $info = null)
    {
        // TODO: Implement resolve() method.
    }
}
<?php


namespace Tools4Schools\Graph\Contracts\Schema\Types;


interface NamedType extends Type
{
    public function name();
}
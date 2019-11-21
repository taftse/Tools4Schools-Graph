<?php


namespace Tools4Schools\Graph\Contracts\Request\Types;


interface WrapperType
{
    /**
     * returns the type that this type wraps
     *
     * @return Type
     */
    public function type():Type;

}
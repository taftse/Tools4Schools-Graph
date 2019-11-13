<?php


namespace Tools4Schools\Graph\Contracts\Schema\Types;


interface FieldType extends ObjectType
{
    // description
    // name
    // type
    // default value
    // directives


    /**
     * returns the Type this field represents
     *
     * @return Type
     */
    public function getType():Type;

    /**
     * Checks to if this Field accepst the argument
     *
     * @param string $argument
     * @return bool
     */
    public function acceptsArgument($argument):bool;

    /**
     * returns all avaialble arguments
     *
     * @return array
     */
    public function getArguments(): array ;

}
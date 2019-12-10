<?php


namespace Tools4Schools\Graph\Contracts\Schema\Types;


interface ObjectType extends NamedType
{
    /**
     * Returns all the fields that are part of this Type
     *
     * @return array
     */
    public function fields():array;

    /**
     * Checks to see if the requested field exists on this type
     *
     * @param string $fieldName
     * @return bool
     */
    public function hasField(string $fieldName):bool;

    /**
     * Returns the requested field
     *
     * @param string $fieldName
     * @param string $throwError = false
     * @return Null|Type
     * @throws FieldNotFoundException
     */
    public function getField(string $fieldName,bool $throwError):?Type;

}
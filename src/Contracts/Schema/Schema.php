<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/09/2019
 * Time: 14:10
 */

namespace Tools4Schools\Graph\Contracts\Schema;


use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType;
use Tools4Schools\Graph\Contracts\Schema\Types\Type;

interface Schema
{



    /**
     * Adds a Type to the schema
     *
     * @param ObjectType $type
     * @throws \Exception
     */
    public function addType(ObjectType $type):void;


    /**
     * Adds multiple types to the schema
     *
     * @param array $types
     * @throws \Exception
     */
    public function addTypes(array $types):void;


    /**
     * returns the root operation type
     *
     * @param $type
     * @return ObjectType
     */
    public function getOperationType($typeName): OperationType;


    /**
     * Checks to see if the operation type exists as part of this schema
     *
     * @param string $typeName
     * @return bool
     */
    public function hasOperationType(string $typeName):bool;


    /**
     * Checks to see if the type exists as part of this schema
     *
     * @param string $typeName
     * @return bool
     */
    public function hasType(string $typeName):bool;


    /**
     * Gets the requested type from the schema
     *
     * @param string $typeName
     * @return ObjectType
     * @throws \Exception
     */
    public function getType(string $typeName):Type;


}
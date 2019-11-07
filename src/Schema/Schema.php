<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/09/2019
 * Time: 14:10
 */

namespace Tools4Schools\Graph\Schema;


use Tools4Schools\Graph\Mutation;
use Tools4Schools\Graph\Query;
use Tools4Schools\Graph\Subscription;
use Tools4Schools\Graph\ObjectType;
use Tools4Schools\Graph\Types\GraphType;

class Schema
{
    protected $types = [];

    protected $operationTypes = [];

    public $directives = [];


    /**
     * Adds a Type to the schema
     *
     * @param ObjectType $type
     * @throws \Exception
     */
    public function addType(ObjectType $type)
    {
        if($type instanceof Mutation)
        {
            $this->operationTypes['mutation'][$type->name()] = $type;
        }
        else if($type instanceof Query)
        {
            $this->operationTypes['query'][$type->name()] = $type;
        }
        else if($type instanceof Subscription)
        {
            $this->operationTypes['subscription'][$type->name()] = $type;
        }
        else if($type instanceof ObjectType)
        {
            $this->types[$type->name()] = $type;
        }
        else
        {
            throw new \Exception('unsupported type');
        }

    }

    /**
     * Adds multiple types to the schema
     *
     * @param array $types
     * @throws \Exception
     */
    public function addTypes(array $types)
    {
        foreach ($types as $type)
        {
            $this->addType($type);
        }
    }


    /**
     *  returns the root operation type
     * @param $type
     * @return ObjectType
     */
    public function getOperationType($type): ObjectType
    {
        return $this->operationTypes[$type];
    }


    /**
     * Checks to see if the type exists as part of this schema
     *
     * @param string $typeName
     * @return bool
     */
    public function hasType(string $typeName):bool
    {
        return isset($this->types[$typeName]);
    }


    /**
     * Gets the requested type from the schema
     *
     * @param string $typeName
     * @return ObjectType
     * @throws \Exception
     */
    public function getType(string $typeName):ObjectType
    {
        if(!$this->hasType($typeName))
        {
            throw new \Exception("Type: ".$typeName." does not exist on this schema");
        }
        return $this->types[$typeName];
    }

    //@todo figure out how to export a Schema to string/SDL
   /*public function toString()
    {

    }*/
}
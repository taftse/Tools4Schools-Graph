<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/09/2019
 * Time: 14:10
 */

namespace Tools4Schools\Graph\Contracts\Schema;


use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType;
use Tools4Schools\Graph\Contracts\Schema\Types\OperationType;
use Tools4Schools\Graph\Contracts\Schema\Types\Type;

interface Schema
{

    /**
     * returns the list of types supported by this Schema
     *
     * @return array
     */
    public function types():array;

    /**
     * returns the list of directives supported by this Schema
     *
     * @return array
     */
    public function directives():array;

    /**
     * Adds a Type to the schema
     *
     * @param ObjectType $type
     * @throws \Exception
     */
    public function addType(Type $type):void;


    /**
     * Adds multiple types to the schema
     *
     * @param array $types
     * @throws \Exception
     */
    public function addTypes(array $types):void;


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

    /**
     * Adds a Directive to the schema
     *
     * @param Directive $directive
     * @throws \Exception
     */
    public function addDirective(Directive $directive):void;


    /**
     * Adds multiple directives to the schema
     *
     * @param array $directives
     * @throws \Exception
     */
    public function addDirectives(array $directives):void;


    /**
     * Checks to see if the directive exists as part of this schema
     *
     * @param string $directiveName
     * @return bool
     */
    public function hasDirective(string $directiveName):bool;


    /**
     * Gets the requested directive from the schema
     *
     * @param string $directiveName
     * @return Directive
     * @throws \Exception
     */
    public function getDirective(string $directiveName):Directive;
}
<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/09/2019
 * Time: 14:12
 */

namespace Tools4Schools\Graph\Types;

use JsonSerializable;

class GraphType implements JsonSerializable
{
    /**
     * The name of the field.
     *
     * @var string
     */
    protected static $name ='';

    /**
     * @var string
     */
    public $description;


    public $type;


    public function __construct($name,array $fields = )
    {

    }


    protected function fields():array
    {
        return [];
    }


    public function name():string
    {
        if(static::$name != '')
        {
            return static::$name;
        }

        return (new \ReflectionClass($this))->getShortName();
    }

    public function getFields()
    {

    }

    public function toArray():array
    {
        return []
    }


}
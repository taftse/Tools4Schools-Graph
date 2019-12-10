<?php


namespace Tools4Schools\Graph\Schema\Types;

use Tools4Schools\Graph\Contracts\Schema\Types\Type as TypeContract;
use Tools4Schools\Graph\Traits\HasResolver;
use Tools4Schools\Graph\Traits\HasValue;

abstract class Type implements TypeContract
{
    use HasResolver,HasValue;
    /**
     * The name of the element.
     *
     * @var string
     */
    public $name;

    /**
     * A description of the element
     *
     * @var string
     */
    public $description;

    /**
     * is this a required field and as such should it always be returned
     *
     * @var bool
     */
    public $required = false;

    /**
     * is this a deprecated field
     *
     * @var bool
     */
    public $deprecated = false;

    /**
     * what is the deprecation reason
     *
     * @var bool
     */
    public $depricatedReason = '';



    public function __construct(string $name = null)
    {
        if(!is_null($name))
        {
            $this->name = $name;
        }
        return $this;
    }


    public function name():string
    {
        if($this->name != '')
        {
            return $this->name;
        }

        return (new \ReflectionClass($this))->getShortName();
    }


    /**
     * Create a new GraphElement.
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Marks this as a required imput
     *
     * @return $this
     */
    public function required()
    {
        $this->required = true;
        return $this;
    }

    /**
     * Marks this as a required imput
     *
     * @param string $reason
     * @return $this
     */
    public function deprecated(string $reason)
    {
        $this->deprecated = true;
        $this->depricatedReason = $reason;
        return $this;
    }

    public function toArray()
    {
        $result['kind'] = $this->type();
        $result['name'] = $this->name();
        $result['description'] = $this->description;
        $result['required'] = $this->required;
        $result['deprecated'] = $this->deprecated;
        $result['deprecatedReason'] = $this->depricatedReason;
        return $result;
    }
}
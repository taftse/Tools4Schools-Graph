<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 01/10/2019
 * Time: 09:38
 */

namespace Tools4Schools\Graph\Language;


class Token
{
    protected $type;

    protected $value;

    protected $position;
    
    public function __construct(string $type,$value,$position = 0)
    {
        $this->type = $type;
        $this->value = $value;
        $this->position = $position;
    }

    public function type():string
    {
        return $this->type;
    }

    public function value()
    {
        return $this->value;
    }

    public function position():int
    {
        return $this->position;
    }
}
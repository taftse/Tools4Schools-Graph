<?php


namespace Tools4Schools\Graph\Language\AST;


use Tools4Schools\Graph\Traits\HasDirectives;
use Tools4Schools\Graph\Traits\HasName;

class FragmentSpread
{
    use HasDirectives,HasName;





    public function __construct($name = null ,array $directives =[])
    {
        $this->name = $name;
        $this->directives = $directives;
    }



}
<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 03/10/2019
 * Time: 21:51
 */

namespace Tools4Schools\Graph\Language\AST;


class FragmentDefinition implements ExecutableDefinition
{
    protected $name ='';

    protected $typeCondition;

    protected $directives;

    protected $selectionSet;

    /**
     * FragmentDefinition constructor.
     * @param string $name name of the fragment
     * @param string $typeCondition the type this fragment belongs to
     * @param array $directives
     * @param array $selectionSet
     */
    public function __construct($name,$typeCondition,array $directives = [],array $selectionSet = [])
    {
        $this->name = $name;
        $this->typeCondition = $typeCondition;
        $this->directives = $directives;
        $this->selectionSet = $selectionSet;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
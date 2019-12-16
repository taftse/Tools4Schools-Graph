<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 03/10/2019
 * Time: 21:51
 */

namespace Tools4Schools\Graph\Language\AST;


use Tools4Schools\Graph\Contracts\Request\FragmentDefinition as FragmentDefinitionContract;
use Tools4Schools\Graph\Language\AST\Types\Type;
use Tools4Schools\Graph\Traits\HasDirectives;
use Tools4Schools\Graph\Traits\HasName;
use Tools4Schools\Graph\Traits\HasSelectionSet;

class FragmentDefinition implements FragmentDefinitionContract
{
    use HasName,HasDirectives,HasSelectionSet;


    protected $typeCondition;


    /**
     * FragmentDefinition constructor.
     * @param string $name name of the fragment
     * @param string $typeCondition the type this fragment belongs to
     * @param array $directives
     * @param array $selectionSet
     */
    public function __construct($name,$typeCondition,array $directives = [],SelectionSet $selectionSet)
    {
        $this->name = $name;
        $this->typeCondition = $typeCondition;
        $this->directives = $directives;
        $this->selectionSet = $selectionSet;
    }



    public function typeCondition():Type
    {
        return $this->typeCondition;
    }

}
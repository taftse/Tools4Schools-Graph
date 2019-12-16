<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 03/10/2019
 * Time: 21:33
 */

namespace Tools4Schools\Graph\Language\AST;



use Tools4Schools\Graph\Contracts\Request\OperationDefinition as OperationDefinitionContract ;
use Tools4Schools\Graph\Traits\HasDirectives;
use Tools4Schools\Graph\Traits\HasName;
use Tools4Schools\Graph\Traits\HasSelectionSet;


class OperationDefinition extends Node implements OperationDefinitionContract
{
    use HasName,HasDirectives,HasSelectionSet;

    protected $operation;

    protected $variableDefinitions =[];



    public function __construct($operation,$name='',array $variableDefinitions = [],SelectionSet $selectionSet,$directives = null,Location $location)
    {
        $this->name = $name;
        $this->operation = $operation;
        $this->variableDefinitions = $variableDefinitions;
        $this->directives = $directives;
        $this->selectionSet = $selectionSet;
    }


    /**
     * Gets the operation type
     * Available options are Query, Mutation and Subscription
     *
     * @return string
     */
    public function getType():string
    {
        return $this->operation;
    }

    public function getVariableDefinitions()
    {
        return $this->variableDefinitions;
    }



}
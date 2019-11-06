<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 03/10/2019
 * Time: 21:33
 */

namespace Tools4Schools\Graph\Language\AST;


use Tools4Schools\Graph\Contracts\Language\Request\AST\ExecutableDefinition;


class OperationDefinition extends Node implements ExecutableDefinition
{
    protected $name ='';

    protected $operation;

    protected $variableDefinitions;

    protected $directives;


    public function __construct($operation,$name='',array $variableDefinitions = [],array $selectionSet = [],$directives = null)
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

}
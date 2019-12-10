<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/09/2019
 * Time: 16:21
 */

namespace Tools4Schools\Graph\Language\AST;


use Tools4Schools\Graph\Contracts\Request\ExecutableDefinition;
use Tools4Schools\Graph\Contracts\Request\Document as DocumentContract;
use Tools4Schools\Graph\Contracts\Request\OperationDefinition;
use Tools4Schools\Graph\Contracts\Request\FragmentDefinition;
use Tools4Schools\Graph\Language\AST\Types\ObjectType;


class Document implements DocumentContract
{
    protected $operations = [];

    protected $fragments = [];

    /**
     * Gets the requested operation
     *
     * @param null $operationName
     * @return OperationDefinition
     * @throws \Exception
     */
    public function getOperation($operationName = null): OperationDefinition
    {
        //If operationName is null:
        if(is_null($operationName)) {
            //If document contains exactly one operation.
            if(count($this->operations) == 1)
            {
                //Return the Operation contained in the document.
                return reset($this->operations);
            }
            //Otherwise produce a query error requiring operationName.
            throw new \Exception('Please specify the operation to execute');

        }
        //Otherwise:
        //Let operation be the Operation named operationName in document
        if(array_key_exists($operationName,$this->operations))
        {
            return $this->operations[$operationName];
        }
        //If operation was not found, produce a query error.
        throw new \Exception('The specified operation does not exist');
    }

    /**
     * Add a executable definition to the request document
     *
     * @param ExecutableDefinition $operation
     */
    public function addDefinition(ExecutableDefinition $operation):void
    {
        if( $operation instanceof OperationDefinition)
        {
            if($operation->name() =='')
            {
                $this->operations[] = $operation;
            }else{
                $this->operations[$operation->name()]= $operation;
            }
        }else if($operation instanceof FragmentDefinition){
            if($operation->name() =='')
            {
                $this->fragments[] = $operation;
            }else{
                $this->fragments[$operation->name()]= $operation;
            }
        }

    }




    public function hasFragment(string $fragmentName):bool
    {
        return isset($this->fragments[$fragmentName]);
    }

    public function getFragment(string $fragmentName):FragmentDefinition
    {
        return $this->fragments[$fragmentName];
    }


}
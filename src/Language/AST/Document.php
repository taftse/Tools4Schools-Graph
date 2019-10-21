<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/09/2019
 * Time: 16:21
 */

namespace Tools4Schools\Graph\Language\AST;


class Document
{
    protected $operations = [];

    protected $fragments = [];

    public function getOperation($operationName = null):OperationDefinition
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

    public function addDirective(ExecutableDefinition $operation)
    {
        if( $operation instanceof OperationDefinition)
        {
            if($operation->getName() =='')
            {
                $this->operations[] = $operation;
            }else{
                $this->operations[$operation->getName()]= $operation;
            }
        }else if($operation instanceof FragmentDefinition){
            if($operation->getName() =='')
            {
                $this->fragments[] = $operation;
            }else{
                $this->fragments[$operation->getName()]= $operation;
            }
        }

    }
}
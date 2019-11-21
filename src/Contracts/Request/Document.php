<?php


namespace Tools4Schools\Graph\Contracts\Request;


use Tools4Schools\Graph\Contracts\Request\ExecutableDefinition;

interface Document
{
    public function addDefinition(ExecutableDefinition $definition):void;

    public function getOperation(string $name):OperationDefinition;

}
<?php


namespace Tools4Schools\Graph\Contracts;


interface Request
{
    public function getQuery():QueryDocument;

    public function getVariables();

    public function getOperationName();
}
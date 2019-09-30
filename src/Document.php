<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/09/2019
 * Time: 16:21
 */

namespace Tools4Schools\Graph;


class Document
{
    protected $operation;

    public function __construct(string $query)
    {
        if($request[0] = "{")
        {
            $this->operation = 'query';

        }else if($request[0] = "_" && $request[1] = "_")
        {
            $this->operation = 'introspection';
        }
        else {
            list($operation, $string) = explode('{', $query, 2);

            switch ($operation) {
                case 'query':
                    $this->operation = 'query';
                    break;
                case 'mutation':
                    $this->operation = 'mutation';
                    break;
                case 'subscription':
                    $this->operation = 'subscription';
                    break;
                default:

                    throw new \Exception('Unsupported operation');

            }
        }
    }

    public function getOperation(){
        return $this->operation;
    }
}
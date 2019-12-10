<?php


namespace Tools4Schools\Graph\Contracts\Schema\Types;


interface Type
{


    /**
     * resolve the requested fields for this type
     *
     * @param Type|null $parent
     * @param array $arguments
     * @param null $context
     * @param null $info the AST of the request
     * @return mixed
     */
    //public function resolve(ObjectType $parent = null,array $arguments = [],$context  = null,$info = null);
    public function resolve(...$arguments);


   // public function toString():string ;

    //public function resolveIntrospection();

    public function kind():Type;

}
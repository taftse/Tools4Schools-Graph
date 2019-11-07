<?php


namespace Tools4Schools\Graph;


use ReflectionClass;

abstract class Query extends ObjectType
{

    /**
     * returns list of arguments
     *
     * @return array
     */
    protected function args() : array
    {
        return [];
    }


    /**
     * The resolver which is called to resolve this query
     *
     * @param null $root
     * @param null $args
     * @return \Closure
     */
    public function resolver($root = null,$args=null)
    {
        return function (){return 'hello world';};
    }



    /**
     * @return array
     */

    abstract protected function type();

    public function fields():array
    {
        // TODO: Implement fields() method.
    }


}
<?php


namespace Tools4Schools\Graph;



use GraphQL\Type\Definition\ObjectType;
use Tools4Schools\Graph\Queries\GetResourceListQuery;
use Tools4Schools\Graph\Queries\GetResourceQuery;

abstract class GraphResource
{

    protected $name;
    // resolver  > eg eloquent

    public function __construct()
    {
        return $this->generateGraphObjectType();
    }


    /**
     * Get the fields returned by the resource
     *
     * @return mixed
     */
    public abstract function fields();



    protected function generateGraphObjectType()
    {
        return new ObjectType([
            'name' => $this->getName()
        ]);
    }


   public function getName(){
        if($this->name == ''){
            return class_basename(get_called_class());
        }
        return $this->name;
    }

    public function type()
    {
        return $this;
    }

    public function resolve($parent){

    }

    public function getQueries()
    {
        //dd((new GetResourceQuery($this))->toArray());
        return [(new GetResourceQuery($this))->toArray(),
                (new GetResourceListQuery($this))->toArray()];
    }
}
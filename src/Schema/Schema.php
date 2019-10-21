<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 30/09/2019
 * Time: 14:10
 */

namespace Tools4Schools\Graph\Schema;


use Tools4Schools\Graph\Types\GraphType;

class Schema
{
    public $types = [];

    public $queries;

    public $mutations;

    public $subscriptions;

    public $directives = [];


    public function __construct($queries,$mutations = null,$subsrciptions = null,array $types = [],array $directives =[] )
    {
       $this->queries = new GraphType($queries);
       $this->mutations = new GraphType($mutations);
       $this->subscriptions = new GraphType($subsrciptions);
       $this->types = $types;
       $this->directives = $directives;
    }


}
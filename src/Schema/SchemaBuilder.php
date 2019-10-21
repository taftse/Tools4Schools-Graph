<?php


namespace Tools4Schools\Graph\Schema;


class SchemaBuilder
{

    /**
     * The registered type names. (Types Definitions)
     *
     * @var array
     */
    public static $types = [];

    /**
     * The registered query names. (Query Definitions)
     *
     * @var array
     */
    public static $queries = [];


    /**
     * The registered mutation names. (Mutation Definitions)
     *
     * @var array
     */
    public static $mutations = [];


    /**
     * The registered subscription names. (Subscription Definitions)
     *
     * @var array
     */
    public static $subscriptions = [];




    public function getSchema()
    {
        return new Schema();
    }
}
<?php

namespace Tools4Schools\Graph\Schema;


use PhpParser\Node\Scalar\MagicConst\Dir;
use Tools4Schools\Graph\Contracts\Schema\Directive;
use Tools4Schools\Graph\Contracts\Schema\Types\Type;
use Tools4Schools\Graph\Contracts\Schema\Types\Query;
use Tools4Schools\Graph\Contracts\Schema\Types\Mutation;
use Tools4Schools\Graph\Contracts\Schema\Types\ObjectType;
use Tools4Schools\Graph\Contracts\Schema\Types\Subscription;
use Tools4Schools\Graph\Contracts\Schema\Types\OperationType;
use Tools4Schools\Graph\Contracts\Schema\Schema as SchemaContract;


use Tools4Schools\Graph\Introspection\Schema as IntrospectionSchema;
use Tools4Schools\Graph\Schema\Types\ListType;
use Tools4Schools\Graph\Schema\Types\NamedListType;
use Tools4Schools\Graph\Types\IntrospectionType;
use Tools4Schools\Graph\Schema\Types\OperationType as Operation;

use Tools4Schools\Graph\Fields\ID;
use Tools4Schools\Graph\Fields\Text;
use Tools4Schools\Graph\Fields\Boolean;
use Tools4Schools\Graph\Fields\Integer;
use Tools4Schools\Graph\Fields\Number;


class Schema implements SchemaContract
{
    protected $types = [];

    //protected $operationTypes = [];

    public $directives = [];

    /**
     * returns a list of types supported by this schema
     *
     * @return array
     */
    public function types():array
    {
        return $this->types;
    }

    public function __construct()
    {
            //$this->types = new NamedListType(Type::class);
            $this->types['Query'] = Operation::make('Query')->required();
            $this->types['Mutation']= Operation::make('Mutation');
            $this->types['Subscription'] = Operation::make('Subscription');

            // if introspection is enabled add the schema query
            $this->addType($this->introspection());

            $this->addType(ID::make());
            $this->addType(Text::make('String'));
            $this->addType(Boolean::make('Boolean'));
            $this->addType(Integer::make('Int'));
            $this->addType(Number::make('Float'));
            //$this->addType(Enum::make('Float'));
            $this->addType(IntrospectionType::make('__Type',$this->types));
    }

    /**
     * Adds a Type to the schema
     *
     * @param ObjectType $type
     * @throws \Exception
     */
    public function addType(Type $type):void
    {
        if ($type instanceof Mutation) {
            $this->types['Mutation']->addOperation($type);
           // $this->types->getItem('mutation')->addOperation($type);
        } else if ($type instanceof Query) {
            $this->types['Query']->addOperation($type);
            //$this->types->getItem('query')->addOperation($type);
        } else if ($type instanceof Subscription) {
            $this->types['Subscription']->addOperation($type);
            //$this->types->getItem('subscription')->addOperation($type);
        } else if ($type instanceof Type) {

            $this->types[$type->name()] = $type;
            //$this->types['__' . $type->name()] = new IntrospectionType($type);

        }else {
            throw new \Exception('A Type with the name [' . $type->name() . '] already exists');
        }

    }

    /**
     * Adds multiple types to the schema
     *
     * @param array $types
     * @throws \Exception
     */
    public function addTypes(array $types):void
    {
        foreach ($types as $type)
        {
            $this->addType($type);
        }
    }



    /**
     * Checks to see if the type exists as part of this schema
     *
     * @param string $typeName
     * @return bool
     */
    public function hasType(string $typeName):bool
    {
        return isset($this->types[$typeName]);
    }


    /**
     * Gets the requested type from the schema
     *
     * @param string $typeName
     * @return ObjectType
     * @throws \Exception
     */
    public function getType(string $typeName):Type
    {
        if(!$this->hasType($typeName))
        {
            throw new \Exception("Type: ".$typeName." does not exist on this schema");
        }
        return $this->types[$typeName];
    }

    public function addDirective(Directive $directive): void
    {
        $this->directives[$directive->name()] = $directive;
    }

    /**
     * Adds multiple types to the schema
     *
     * @param array $types
     * @throws \Exception
     */
    public function addDirectives(array $directives):void
    {
        foreach ($directives as $directive)
        {
            $this->addDirective($directive);
        }
    }





    /**
     * Checks to see if the type exists as part of this schema
     *
     * @param string $typeName
     * @return bool
     */
    public function hasDirective(string $directiveName):bool
    {
        return isset($this->directives[$directiveName]);
    }


    /**
     * Gets the requested type from the schema
     *
     * @param string $typeName
     * @return ObjectType
     * @throws \Exception
     */
    public function getDirective(string $directiveName):Directive
    {
        if(!$this->hasDirective($directiveName))
        {
            throw new \Exception("Directive: ".$directiveName." does not exist on this schema");
        }
        return $this->directives[$directiveName];
    }


    /**
     * returns a list of directives supported by this schema
     *
     * @return array
     */
    public function directives():array
    {
        return $this->directives;
    }




    public function toArray()
    {
        $result = [];
        foreach($this->types as $type)
        {
            $result['types'][$type->name()] = $type->toArray();
        }

        foreach($this->directives as $directive)
        {
            $result['directives'][$directive->name()] = $directive->toArray();
        }

        return $result;
    }

    //@todo figure out how to export a Schema to string/SDL
   /*public function toString()
    {

    }*/

   protected function introspection():OperationType
   {
       return new IntrospectionSchema($this);
   }//*/
}
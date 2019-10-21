<?php
namespace Tools4Schools\Graph;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;

class Draft{

    public function __construct()
    {
        $user = new ObjectType([
            'name'=>'User',
            'fields' =>[
                'id'=> Type::ID(),
                'name' =>[
                    'type' => Type::string(),
                ],
                'email' => Type::string(),
            ],
        ]);

        return new Schema([
            'query' => new ObjectType([
                'name' =>'Query',
                'fields' => [
                    'GetUserQuery'=>[
                        'name'=>'GetUserQuery',
                        'type'=>$user,
                        'fields'=>[$user],
                    ],
                ],
            ]),
            'mutation' => new ObjectType([
                'name' =>'Mutation',
                'fields' => [
                    'addUserMutation'=>[
                        'name'=>'GetUserQuery',
                        'type'=>$user,
                        'fields'=>[$user],
                    ],
                    'updateUserMutation'=>[
                        'name'=>'GetUserQuery',
                        'type'=>$user,
                        'fields'=>[$user],
                    ],
                ],
            ])
        ]);
    }
}
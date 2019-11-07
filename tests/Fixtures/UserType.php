<?php


namespace Tools4Schools\Graph\Tests\Fixtures;




use Illuminate\Http\Request;
use Tools4Schools\Graph\ObjectType;
use Tools4Schools\Graph\Fields\ID;
use Tools4Schools\Graph\Fields\Text;
use Tools4Schools\Graph\Fields\HasOne;

class UserType extends ObjectType
{
    public static $model = \Tools4Schools\Graph\Tests\Fixtures\User::class;


    public function fields()
    {
        return [
            ID::make(),
            Text::make('First Name'),
            Text::make('Last Name'),
            Text::make('Email'),
            Text::make('Password'),

            HasOne::make('Address','address',AddressResource::class),
        ];
    }
}
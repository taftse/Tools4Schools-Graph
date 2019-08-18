<?php

use Illuminate\Support\Facades\Route;

// Resource Management...
route::get('/','GraphQueryController@handle');
route::post('/','GraphMutationController@handle');



/*
Route::get('/{resource}', 'ResourceIndexController@handle');
Route::get('/{resource}/{resourceId}', 'ResourceShowController@handle');*/
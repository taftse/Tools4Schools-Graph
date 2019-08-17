<?php

use Illuminate\Support\Facades\Route;

// Resource Management...
Route::get('/{resource}', 'ResourceIndexController@handle');
Route::get('/{resource}/{resourceId}', 'ResourceShowController@handle');
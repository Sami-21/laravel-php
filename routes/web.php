<?php

use Illuminate\Support\Facades\Route;

 

Route::get('/', function () {
    return view('index');
});

Route::get('stores', "StoreController@get");

Route::post('stores', "StoreController@post");

Route::put('stores', "StoreController@update");

Route::delete('store/{id}', "StoreController@delete");
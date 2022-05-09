<?php

use Illuminate\Support\Facades\Route;

 

Route::get('/', function () {
    return view('index');
});

Route::get('stores', "StoreController@getStores");

Route::post('stores', "StoreController@addStore");

Route::put('stores', "StoreController@updateStore");

Route::delete('store/{id}', "StoreController@removeStore");

Route::get('products', "ProductController@getProducts");

Route::post('products', "ProductController@addProduct");

Route::put('products', "ProductController@updateProduct");

Route::delete('product/{id}', "ProductController@removeProduct");

//Client Route

Route::get('clients', "ClientController@GetClients");

Route::post('clients', "ClientController@addClient");

Route::put('clients/{id}', "ClientController@UpdateClient");

Route::delete('clients/{id}', "ClientController@DeleteClient");
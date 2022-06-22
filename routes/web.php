<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('index');
});

//Client Routes

Route::get('clients', "ClientController@getClients");

Route::post('clients', "ClientController@addClient");

Route::put('clients/{id}', "ClientController@updateClient");

Route::delete('clients/{id}', "ClientController@deleteClient");


// Provider Routes

Route::get('providers', "ProviderController@getProviders");

Route::post('providers', "ProviderController@addProvider");

Route::put('providers/{id}', "ProviderController@updateProvider");

Route::delete('providers/{id}', "ProviderController@deleteProvider");

// Product Routes

Route::get('products', "ProductController@getProducts");

Route::post('products', "ProductController@addProduct");

Route::put('products/{id}', "ProductController@updateProduct");

Route::delete('products/{id}', "ProductController@deleteProduct");

// Transactions Routes

Route::get('transactions', "TransactionController@getTransactions");

Route::post('transactions', "TransactionController@addTransaction");

Route::put('transactions/{id}', "TransactionController@updateTransaction");

Route::delete('transactions/{id}', "TransactionController@deleteTransaction");
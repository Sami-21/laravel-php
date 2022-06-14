<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Transaction;
use App\Client;
use App\Provider;

class TransactionController extends Controller
{
    function getTransactions()
    {
        return  Transaction::all();
    }

    function addTransaction(TransactionRequest $request)
    {

        $validated = $request->validated();

        if (Client::get()->contains('id', $request->client_id) && Provider::get()->contains('id', $request->provider_id)) {

            Transaction::create($validated);
        }
    }
}
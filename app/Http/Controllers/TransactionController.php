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
        $transaction = Transaction::create($validated);
        $transaction->products()->attach($request->products);
    }
}


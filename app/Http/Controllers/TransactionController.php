<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Transaction;

class TransactionController extends Controller
{
    function getTransactions()
    {
        return  Transaction::all();
    }

    // function addTransaction(TransactionRequest $request)
    // {
    //     $validated = $request->validated();

    //     Transaction::create($validated);
    // }
}
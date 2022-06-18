<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Transaction;
use App\Product;


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
        foreach ($request->products as $product) {
            $transaction->products()->attach(
                [
                    $product['product']['id'],
                    ['quantity' => $product['quantity']],
                    ['price' => $product['product']['price']],
                ]
            );
        }
    }
}
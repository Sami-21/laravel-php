<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Transaction;
use App\Product;
use Illuminate\Auth\Events\Validated;

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
        foreach ($validated['products'] as $product) {

            $transaction->products()->attach(

                $product['product_id'],
                [
                    'price' => $product['price'],
                    'quantity' => $product['quantity']
                ]

            );
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Transaction;
use Illuminate\Auth\Events\Validated;

class TransactionController extends Controller
{
    function getTransactions()
    {
        $transactions =  Transaction::with(['client', 'provider', 'products'])->get();

        return $transactions;
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


    function deleteTransaction($id)
    {

        $transaction =  Transaction::findOrFail($id);

        $transaction->products()->detach();

        $transaction->delete();
    }

    function updateTransaction(TransactionRequest $request, $id)
    {

        $transaction =  Transaction::findOrFail($id);

        $transaction->products()->detach();

        $validated = $request->validated();

        $transaction->update($validated);

        foreach ($transaction->products as $product) {
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
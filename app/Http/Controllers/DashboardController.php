<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Provider;
use App\Product;
use App\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function getCounts(Request $request)
    {
        $counts = [
            count(Client::all()),
            count(Provider::all()),
            count(Product::all()),
            count(Transaction::all())
        ];

        $topTransactionsClients = Client::withCount(['transactions'])->orderBy('transactions_count', 'desc')->take(5)->get();

        $topTransactions = Transaction::orderBy('total', 'desc')->take(5)->get();

        $topSpendingClients = Client::addSelect(['total' => Transaction::selectRaw('sum(total) as total')->whereColumn('client_id', 'clients.id')])->groupBy('clients.id')->orderBy('total', 'desc')->take(5)->get();

        $topSellingProducts =  Product::addSelect(['totalSoldUnits' => DB::table('product_transaction')->selectRaw('sum(quantity) as totalSoldUnits')->whereColumn('product_id', 'products.id')->groupBy('products.id')])->orderBy('totalSoldUnits', 'desc')->take(5)->get();

        $data = [
            "count" => $counts,
            "topTransactionsClients" => $topTransactionsClients,
            "topSpendingClients" => $topSpendingClients,
            "topSellingProducts" => $topSellingProducts,
            "topTransactions" => $topTransactions,
        ];

        return response()->json($data);
    }
}
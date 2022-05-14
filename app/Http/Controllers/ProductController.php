<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;

class ProductController extends Controller
{
    function getProducts()
    {
        return  Product::all();
    }

    function addProduct(ProductRequest $request)
    {
        $validated = $request->validated();

        Product::create($validated);
    }

    function updateProduct(ProductRequest $request, $id)
    {
        $validated = $request->validated();
        Product::find($id)->update($validated);
    }

    function deleteProduct($id)
    {
        Product::find($id)->delete();
    }
}
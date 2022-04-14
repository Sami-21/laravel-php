<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;
use App\Store;

class ProductController extends Controller
{
    function GetProducts(){
        return Product::all() ;
    }
    function addProduct(ProductRequest $request){
        
        $store = Store::where('name',$request->store)->first() ;
        
        Product::create(["name" => $request->name,'quantity' => $request->quantity,'price' => $request->price,"store_id" => $store->id]);
        
    }
    function removeProduct($id){

        Product::find($id)->delete();
    }
    function updateProduct(ProductRequest $request){
        $validated = $request->validated();

        Store::where('id',$request->id )->update($validated);
    }
}
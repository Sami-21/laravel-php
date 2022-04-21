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
        //selecting the product's store  
        $store = Store::where('name',$request->store)->first() ;
        //Creating a product with the data from the request object + the id of the previously selected store
        Product::create(["name" => $request->name,'quantity' => $request->quantity,'price' => $request->price,'store' => $request->store,"store_id" => $store->id]);

    }
    function removeProduct($id){
        Product::find($id)->delete();
    }
    
    function updateProduct(ProductRequest $request){
       Product::find($request->id)->update($request->all());
    }
}
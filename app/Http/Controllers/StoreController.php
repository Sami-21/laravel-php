<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Product;
use App\Store;

class StoreController extends Controller
{

    // Post Request
    public function addStore(StoreRequest $request ){
        
        $validated = $request->validated();

        Store::create($validated);   
    }

    // Get Request
    public function getStores(){
        return Store::all();
    }

    // Update Request
    public function updateStore(StoreRequest $request){
        
        $validated = $request->validated();

        Store::where('id',$request->id )->update($validated);
        
        Product::where('store_id',$request->id)->update(['store' => $request->name]);
    }

    // Delete Request
    public function removeStore($id){
        Store::where('id',$id)->delete();
    }
}
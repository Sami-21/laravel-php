<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
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

    // Put Request
    public function updateStore(StoreRequest $request){
        
        $validated = $request->validated();

        Store::where('id',$request->id )->update($validated);
    }

    // Delete Request
    public function removeStore($id){
        Store::where('id',$id)->delete();
    }
}
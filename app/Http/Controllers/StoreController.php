<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Store;

class StoreController extends Controller
{

    // post Request
    public function post(StoreRequest $request ){
        
        $validated = $request->validated();

        Store::create($validated);   
    }

    // Get Request
    public function get(){
        return Store::all();
    }

    // Put Request
    public function update(StoreRequest $request){
        
        $validated = $request->validated();

        Store::where('id',$request->id )->update($validated);
    }

    // Delete Request
    public function delete($id){
        Store::where('id',$id)->delete();
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    function GetClients(){
        return  Client::all();
    }
    function AddClient(ClientRequest $request){
        $validated = $request->validated();

        Client::create($validated);
    }
    function UpdateClient(ClientRequest $request ,$id){
        $validated = $request->validated();
        Client::find($id)->update($validated);
    }
    function DeleteClient($id){
        Client::find($id)->delete();
    }
}

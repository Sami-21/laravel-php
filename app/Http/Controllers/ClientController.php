<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Client;

class ClientController extends Controller
{
    function getClients()
    {
        return  Client::all();
    }

    function addClient(ClientRequest $request)
    {
        $validated = $request->validated();

        Client::create($validated);
    }

    function updateClient(ClientRequest $request, $id)
    {
        $validated = $request->validated();
        Client::find($id)->update($validated);
    }

    function deleteClient($id)
    {
        Client::find($id)->delete();
    }
}
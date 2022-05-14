<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderRequest;
use App\Provider;


class ProviderController extends Controller
{
    function getProviders()
    {
        return  Provider::all();
    }

    function addProvider(ProviderRequest $request)
    {
        $validated = $request->validated();

        Provider::create($validated);
    }

    function updateProvider(ProviderRequest $request, $id)
    {
        $validated = $request->validated();
        Provider::find($id)->update($validated);
    }

    function deleteProvider($id)
    {
        Provider::find($id)->delete();
    }
    
}
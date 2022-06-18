<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        "client_id",
        "provider_id",
        "total",
    ];

    public function client()
    {
        return $this->belongsTo("App\Client");
    }

    public function provider()
    {
        return $this->belongsTo("App\Provider");
    }
    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot(['quantity', 'price']);
    }
}
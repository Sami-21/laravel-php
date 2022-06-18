<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name",
        "price",
        "quantity",
        "description",
    ];
    public function transactions()
    {
        return $this->belongsToMany('App\Transaction')->withPivot(['quantity', 'price']);
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'quantity',
        'price',
        'store',
        'store_id',
    ];
    public function store() {
        return $this->BelongsTo(Store::class);
    } 
}
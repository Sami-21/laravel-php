<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        "name",
        "email",
        "phone",
        "address",
    ];
    
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
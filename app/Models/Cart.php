<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'quantity'
    ];

    protected $with = ['product'];

    function product() 
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}

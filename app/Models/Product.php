<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name', 'price', 'stock'
    ];

    public function take($quantity = 1)
    {
        $this->stock -= $quantity;
        $this->save();
        return $this;
    }
}

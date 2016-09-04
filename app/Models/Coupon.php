<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'code', 'description', 'stock', 'amount', 'amount_type', 'valid_from', 'valid_until'
    ];

    protected $dates = ['valid_from', 'valid_until'];
}

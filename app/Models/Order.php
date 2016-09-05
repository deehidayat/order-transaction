<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        // 'invoice_no', 'expire_date', 'coupon_type', 'coupon_amount', 'coupon_total', 'shipping_no', 'shipping_price', 'subtotal', 'total'
    ];

    public function details()
    {
        return $this->hasMany('App\Models\OrderDetail', 'invoice_no', 'invoice_no');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\OrderPayment', 'invoice_no', 'invoice_no');
    }
}

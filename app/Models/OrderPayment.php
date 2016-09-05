<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_no', 'payment_date', 'bank_name', 'account_name', 'account_number', 'transfered_by', 'amount', 'file_url'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'invoice_no', 'invoice_no');
    }
}

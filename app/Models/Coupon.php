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

    public function calculate($price)
    {
        $total = 0;
        switch ($this->amount_type) {
            case 'percentage':
                $total = $price * $this->amount / 100;
                break;
            
            default:
                $total = $this->amount;
                break;
        }    
        return $total;
    }

    public function take($quantity = 1)
    {
        $this->stock -= $quantity;
        $this->save();
        return $this;
    }
}

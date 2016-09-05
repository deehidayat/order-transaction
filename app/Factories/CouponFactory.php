<?php
namespace App\Factories;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponFactory extends AbstractFactory
{
    protected function getModelClass() 
    {
        return Coupon::class;
    }

    public function getFilterAttributes()
    {
        return ['id', 'code', 'description', 'stock', 'amount', 'amount_type', 'valid_from', 'valid_until'];
    }

    public function validateCreateRequest(Array $data) {
        $result = app('validator')->make($data, [
            'code' => 'required|unique:coupons',
            'description' => 'required|unique:coupons',
            'amount' => 'numeric|required',
            'amount_type' => 'required|in:percentage,money',
            'valid_from' => 'date|required',
            'valid_until' => 'date|required',
        ]);
        if (count($result->messages())) {
            throw new \Exception($result->messages());
        }
        return $data;
    }

    public function validateUpdateRequest(Array $data, $id) {
        $result = app('validator')->make($data, [
            'code' => "unique:coupons,code,{$id}",
            'description' => "unique:coupons,description,{$id}",
            'amount' => 'numeric|min:0',
            'amount_type' => 'in:percentage,money',
            'valid_from' => 'date',
            'valid_until' => 'date',
        ]);
        if (count($result->messages())) {
            throw new \Exception($result->messages());
        }
        return $data;
    }
}
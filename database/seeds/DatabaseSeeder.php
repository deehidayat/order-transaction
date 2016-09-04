<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        $this->call('ProductsSeeder');
        $this->call('CouponsSeeder');
    }
}


class ProductsSeeder extends Seeder
{
    
    public function run() {

        $product = App\Models\Product::find(1);
        if (empty($product)) {
            $product = App\Models\Product::create(['id' => 1, 'code' => 'ITEM#1', 'name' => 'Product 1', 'price' => 125000, 'stock' => 10 ]);
        } else {
            $product->update(['code' => 'ITEM#1', 'name' => 'Product 1', 'price' => 125000, 'stock' => 10 ]);
        }

        $product = App\Models\Product::find(2);
        if (empty($product)) {
            $product = App\Models\Product::create(['id' => 2, 'code' => 'ITEM#2', 'name' => 'Product 2', 'price' => 200000, 'stock' => 10 ]);
        } else {
            $product->update(['code' => 'ITEM#2', 'name' => 'Product 2', 'price' => 200000, 'stock' => 10 ]);
        }
    }
}

class CouponsSeeder extends Seeder
{
    
    public function run() {

        $coupon = App\Models\Coupon::find(1);
        if (empty($coupon)) {
            $coupon = App\Models\Coupon::create(['id' => 1, 'code' => 'COUPON#1', 'description' => 'Coupon 1', 'amount' => 10, 'amount_type' => 'percentage', 'valid_from' => date('Y-m-d'), 'valid_until' => date('Y-m-d', strtotime("+3 Days"))]);
        } else {
            $coupon->update(['id' => 1, 'code' => 'COUPON#1', 'description' => 'Coupon 1', 'amount' => 10, 'amount_type' => 'percentage', 'valid_from' => date('Y-m-d'), 'valid_until' => date('Y-m-d', strtotime("+3 Days"))]);
        }

        $coupon = App\Models\Coupon::find(2);
        if (empty($coupon)) {
            $coupon = App\Models\Coupon::create(['id' => 2, 'code' => 'COUPON#2', 'description' => 'Coupon 2', 'amount' => 100000, 'amount_type' => 'money', 'valid_from' => date('Y-m-d'), 'valid_until' => date('Y-m-d', strtotime("+3 Days"))]);
        } else {
            $coupon->update(['id' => 2, 'code' => 'COUPON#2', 'description' => 'Coupon 2', 'amount' => 100000, 'amount_type' => 'money', 'valid_from' => date('Y-m-d'), 'valid_until' => date('Y-m-d', strtotime("+3 Days"))]);
        }
    }
}

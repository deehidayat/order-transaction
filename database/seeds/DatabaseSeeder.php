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

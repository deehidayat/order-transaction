<?php
namespace App\Factories;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductFactory extends AbstractFactory
{
    protected function getModelClass() 
    {
        return Product::class;
    }

    public function getFilterAttributes()
    {
        return ['id', 'code', 'name', 'price', 'stock'];
    }

    public function validateCreateRequest(Array $data) {
        $result = app('validator')->make($data, [
            'code' => 'required|unique:products',
            'name' => 'required|unique:products',
            'price' => 'min:0',
            'stock' => 'min:0'
        ]);
        if (count($result->messages())) {
            throw new \Exception($result->messages());
        }
        return $data;
    }

    public function validateUpdateRequest(Array $data, $id) {
        $result = app('validator')->make($data, [
            'code' => "unique:products,code,{$id}",
            'name' => "unique:products,name,{$id}",
            'price' => 'min:0',
            'stock' => 'min:0'
        ]);
        if (count($result->messages())) {
            throw new \Exception($result->messages());
        }
        return $data;
    }
}
<?php
namespace App\Factories;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartFactory extends AbstractFactory
{
    protected function getModelClass() 
    {
        return Cart::class;
    }

    public function getFilterAttributes()
    {
        return ['product_id'];
    }

    public function validateCreateRequest(Array $data) {
        $result = app('validator')->make($data, [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|min:0'
        ]);
        if (count($result->messages())) {
            throw new \Exception($result->messages());
        }
        return $data;
    }

    public function validateUpdateRequest(Array $data, $id) {
        $result = app('validator')->make($data, [
            'product_id' => 'exists:products,id',
            'quantity' => 'min:0'
        ]);
        if (count($result->messages())) {
            throw new \Exception($result->messages());
        }
        return $data;
    }

    /**
     * @Override
     */
    public function create(Request $request)
    {
        $data = $request->input();

        $this->validateCreateRequest($data);

        $prevProduct = $this->model->where('product_id', $data['product_id'])->first();

        if (empty($prevProduct)) {
            $record = $this->model->create($data);
        } else {
            $prevProduct->quantity = $prevProduct->quantity + $data['quantity'];
            $prevProduct->save();
            $record = $prevProduct;
        }
        
        if (!empty($record)) {
            return $record;
        } else {
            throw new \Exception('Failed To Create Record');
        }
    }
}
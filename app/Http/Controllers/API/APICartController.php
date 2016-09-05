<?php

namespace App\Http\Controllers\API;

use App\Factories\CartFactory;
use App\Factories\OrderFactory;
use Illuminate\Http\Request;

class APICartController extends AbstractController
{   
    private $orderFactory;

    function __construct(CartFactory $factory, OrderFactory $orderFactory) {
        $this->factory = $factory;
        $this->orderFactory = $orderFactory;
    }

    /**
     * API for process whole product in Cart to Order
     */
    public function placeOrder(Request $request)
    {
        try {
            $record = $this->orderFactory->placeOrder($request);
        } catch (\Exception $e) {
            return $this->response([
                'error' => json_decode($e->getMessage()) ? json_decode($e->getMessage()) : $e->getMessage()
            ]);    
        }
        return $this->response([
            'data' => $record,
            'success' => true
        ]);
    }
}

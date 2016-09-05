<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Factories\OrderFactory;

class APIOrderController extends AbstractController
{
    function __construct(OrderFactory $factory) {
        $this->factory = $factory;
    }

    public function payment(Request $request, $invoiceNo) {
        $data = $request->input();
        $data['invoice_no'] = $invoiceNo;
        $data['file'] = $request->file('file');
        try {
            $record = $this->factory->createPayment($data);
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

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

    /**
     * This method will restricted to admin
     */
    public function reject(Request $request, $invoiceNo) {
        $data = $request->input();
        $data['invoice_no'] = $invoiceNo;
        try {
            $record = $this->factory->reject($data);
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

    /**
     * This method will restricted to admin
     */
    public function approve(Request $request, $invoiceNo) {
        $data = $request->input();
        $data['invoice_no'] = $invoiceNo;
        try {
            $record = $this->factory->approve($data);
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

    /**
     * This method will restricted to admin
     */
    public function shipped(Request $request, $invoiceNo) {
        $data = $request->input();
        $data['invoice_no'] = $invoiceNo;
        try {
            $record = $this->factory->shipped($data);
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

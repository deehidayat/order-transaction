<?php
namespace App\Factories;

use App\Models\Order;
use Illuminate\Http\Request;

use App\Models\OrderDetail;
use App\Models\Coupon;
use App\Models\Cart;

use App\Models\OrderPayment;
use Illuminate\Support\Facades\Storage;

class OrderFactory extends AbstractFactory
{
    protected function getModelClass() 
    {
        return Order::class;
    }

    public function getFilterAttributes()
    {
        return ['id', 'invoice_no'];
    }

    public function validateCreateRequest(Array $data) {
        $result = app('validator')->make($data, [
            'invoice_no' => 'required|unique:orders',
            
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            
            'address' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'sub_district' => 'required',
            'postal_code' => 'required',

            'coupon_code' => 'exists:coupons,code',

            'shipping_name' => 'required',
        ]);
        if (count($result->messages())) {
            throw new \Exception($result->messages());
        }
        return $data;
    }

    public function validateUpdateRequest(Array $data, $id) {
        $result = app('validator')->make($data, [
            'coupon_code' => 'exists:coupons'
        ]);
        if (count($result->messages())) {
            throw new \Exception($result->messages());
        }
        return $data;
    }

    protected function generateNumber()
    {
        return 'ORDER-' . date('U');
    }

    public function placeOrder(Request $request)
    {
        $data = $request->input();
        $data['invoice_no'] = $this->generateNumber();
        $data['total'] = 0;

        $this->validateCreateRequest($data);

        $errors = [];

        /**
         * Validate Product
         */
        $carts = Cart::all();
        if (!count($carts)) {
            throw new \Exception('There\'s no product selected');
        }
        $details = [];
        $data['subtotal'] = 0;
        foreach ($carts as $key => $cart) {
            if ($cart->quantity > $cart->product->stock) {
                $out = $cart->product->stock - $cart->quantity;
                $errors[] = [
                    $cart->product->name => "Out of stock ($out)"
                ];
            } else {
                $total = $cart->quantity * $cart->product->price;
                $details[] = new OrderDetail([
                    'code' => $cart->product->code,
                    'name' => $cart->product->name,
                    'price' => $cart->product->price,
                    'quantity' => $cart->quantity,
                    'total' => $total
                ]);
                $data['subtotal'] += $total;
            }
        }
        $data['total'] += $data['subtotal'];

        /**
         * Validate Shipment
         * By now shipment is free of charge
         */
        $data['shipping_price'] = 0;
        $data['total'] += $data['shipping_price'];

        /**
         * Validate Coupon
         */
        $data['coupon_total'] = 0;
        $coupon = null;
        if (!count($errors) && isset($data['coupon_code'])) {
            $now = date('Y-m-d');
            $coupon = Coupon::where('code', $data['coupon_code'])
                    ->where('stock', '>', 0)
                    ->where('valid_from', '<=', $now)
                    ->where('valid_until', '>=', $now)->first();
            if (empty($coupon)) {
                throw new \Exception('Coupon expired and or out of stock');
            } else {
                $data['coupon_type'] = $coupon->amount_type;
                $data['coupon_amount'] = $coupon->amount;
                $data['coupon_total'] = $coupon->calculate($data['subtotal']);
            }
        }
        $data['total'] -= $data['coupon_total'];

        if (count($errors)) {
            throw new \Exception(json_encode($errors));
        }

        $data['status'] = 'pending_payment';

        $order = $this->model->create($data);
        if (!empty($order)) {
            /**
             * Insert Details
             */
            $order->details()->saveMany($details);
            /**
             * Decrease coupon
             */
            if (!empty($coupon)) {
                $coupon->take();
            }
            /**
             * Decrease product and remove cart
             */
            foreach ($carts as $key => $cart) {
                $cart->product->take($cart->quantity);
                $cart->delete();
            }
            return $order;
        } else {
            throw new \Exception('Failed To Create Order');
        }

        return $record;
    }

    public function createPayment($data)
    {
        $result = app('validator')->make($data, [
            'invoice_no' => 'required|exists:orders',
            'payment_date' => 'required|date',
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_number' => 'required',
            'transfered_by' => 'required',
            'amount' => 'required|numeric|min:0',
            'file' => 'image|mimes:png,jpg,jpeg',
        ]);
        if (count($result->messages())) {
            throw new \Exception($result->messages());
        }
        $order = $this->model->where('invoice_no', $data['invoice_no'])
            ->where('status', 'pending_payment')->first();
        if (empty($order)) {
            throw new \Exception('Selected Order cannot be proccessed');
        }
        /**
         * Upload File
         */
        if (!empty($data['file'])) {
            $fileUrl = 'payments/'.rand().'-'.$data['file']->getClientOriginalName();
            Storage::put(
                $fileUrl,
                file_get_contents($data['file']->getRealPath())
            );
            $data['file_url'] = $fileUrl;
        }
        $record = $order->payments()->create($data);
        if (!empty($record)) {
            $order->update(['status' => 'paid']);
            return $record;
        } else {
            throw new \Exception('Failed To Create Payment');
        }
    }

    public function reject($data)
    {
        $result = app('validator')->make($data, [
            'invoice_no' => 'required|exists:orders'
        ]);
        if (count($result->messages())) {
            throw new \Exception($result->messages());
        }
        $order = $this->model->where('invoice_no', $data['invoice_no'])->first();
        if (empty($order)) {
            throw new \Exception('Order not found');
        }
        try {
            $order->update(['status' => 'rejected']);
            return $order;
        } catch (Exception $e) {   
            throw new \Exception('Failed to reject order');
        }
    }

    public function approve($data)
    {
        $result = app('validator')->make($data, [
            'invoice_no' => 'required|exists:orders'
        ]);
        if (count($result->messages())) {
            throw new \Exception($result->messages());
        }
        $order = $this->model->where('invoice_no', $data['invoice_no'])->first();
        if (empty($order)) {
            throw new \Exception('Order not found');
        }
        try {
            $order->update(['status' => 'ready_for_shipment']);
            return $order;
        } catch (Exception $e) {   
            throw new \Exception('Failed to approve order');
        }
    }

    public function shipped($data)
    {
        $result = app('validator')->make($data, [
            'invoice_no' => 'required|exists:orders',
            'shipping_no' => 'required|unique:orders'
        ]);
        if (count($result->messages())) {
            throw new \Exception($result->messages());
        }
        $order = $this->model->where('invoice_no', $data['invoice_no'])->first();
        if (empty($order)) {
            throw new \Exception('Order not found');
        }
        try {
            $order->update(['status' => 'shipped', 'shipping_no' => $data['shipping_no']]);
            return $order;
        } catch (Exception $e) {   
            throw new \Exception('Failed to ship order');
        }
    }

}
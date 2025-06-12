<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function viewCheckout()
    {
        $cartId = Cart::where('user_id', session('userData')->id)->first()->id;
        $cartItems = CartItem::where('cart_id', $cartId)->get();
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->product->price * $cartItem->quantity;
        }
        return view('cms.checkout.checkout', compact('cartItems', 'totalPrice', 'cartId'));
    }

    public function orders(PaymentRequest $request)
    {
        DB::beginTransaction();
        try {
            $cartId = Cart::where('user_id', session('userData')->id)->first()->id;
            $cartItems = CartItem::where('cart_id', $cartId)->get();
            if ($request->payment == 'vnpay') {
                //
            } elseif ($request->payment == 'cod') {
                $order = Order::create([
                    'user_id' => session('userData')->id,
                    'status' => 'pending',
                    'payment' => 'cod',
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'name' => $request->name,
                    'email' => $request->email,
                    'total_price' => $request->total_price,
                ]);
                if ($order) {
                    foreach ($cartItems as $cartItem) {
                        $orderItem = OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $cartItem->product_id,
                            'quantity' => $cartItem->quantity,
                            'size' => $cartItem->size,
                        ]);
                        $cartItem->delete();
                    }
                }
                $orderWithItems = Order::with('orderItems.product')->find($order->id);
                DB::commit();
                return view('cms.checkout.payment_success' , compact('orderWithItems'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return view('cms.checkout.payment_failed');
        }
    }

    public function createVNPayPayment(Request $request)
    {
        $vnp_TmnCode    = config('vnpay.vnp_TmnCode');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_Url        = config('vnpay.vnp_Url');
        $vnp_Returnurl  = config('vnpay.vnp_ReturnUrl');

        $vnp_TxnRef     = uniqid();
        $vnp_OrderInfo  = 'Thanh toan don hang ' . $vnp_TxnRef;
        $vnp_Amount     = ((int) $request->amount) * 100;

        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $vnp_Amount,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $request->ip(),
            "vnp_Locale"     => "vn",
            "vnp_OrderInfo"  => $vnp_OrderInfo,
            "vnp_OrderType"  => "billpayment",
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_TxnRef"     => $vnp_TxnRef,
        ];

        ksort($inputData);

        $hashData = urldecode(http_build_query($inputData)); // hoặc tự tạo thủ công

        $vnp_SecureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $inputData['vnp_SecureHash'] = $vnp_SecureHash;

        $redirectUrl = $vnp_Url . '?' . http_build_query($inputData);

        return redirect($redirectUrl);
    }

    public function vnpayReturn(Request $request)
    {
        if ($request->vnp_ResponseCode == '00') {
            return view('cms.checkout.payment_success');
        } else {
            return view('cms.checkout.payment_failed');
        }
    }
}

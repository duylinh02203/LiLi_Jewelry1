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
        if ($totalPrice <= 0) {
            return redirect()->route('shop')->with('error', 'Không thể thanh toán vì giỏ hàng trống');
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
                $vnp_Url = config('vnpay.vnp_Url');
                $vnp_Returnurl = config('vnpay.vnp_ReturnUrl');
                $vnp_TmnCode = config('vnpay.vnp_TmnCode');
                $vnp_HashSecret = config('vnpay.vnp_HashSecret');

                $vnp_TxnRef = time();
                $vnp_OrderInfo = "Thanh toan don hang ";
                $vnp_OrderType = "billpayment";
                $vnp_Amount = $request->total_price * 100;
                $vnp_OrderType = "billpayment";
                $vnp_Locale = "vn";
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef
                );

                if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                    $inputData['vnp_Bill_State'] = $vnp_Bill_State;
                }
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }
                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }
                session(['orderData' => [
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'name' => $request->name,
                    'email' => $request->email,
                    'total_price' => $request->total_price,
                ]]);
                return redirect($vnp_Url);
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
                return view('cms.checkout.payment_success', compact('orderWithItems'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return view('cms.checkout.payment_failed');
        }
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        if ($vnp_ResponseCode == '00') {
            $cartId = Cart::where('user_id', session('userData')->id)->first()->id;
            $cartItems = CartItem::where('cart_id', $cartId)->get();
            $order = Order::create([
                'user_id' => session('userData')->id,
                'status' => 'pending',
                'payment' => 'vnpay',
                'phone' => session('orderData')['phone'],
                'address' => session('orderData')['address'],
                'name' => session('orderData')['name'],
                'email' => session('orderData')['email'],
                'total_price' => session('orderData')['total_price'],
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
            return view('cms.checkout.payment_success', compact('orderWithItems', 'order'));
        } elseif ($vnp_ResponseCode == null) {
            return view('cms.cart.cart');
        } elseif ($vnp_ResponseCode != '00' && $vnp_ResponseCode != null) {
            return view('cms.checkout.payment_failed');
        }
    }
}

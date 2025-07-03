<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSize;
use App\Models\UserInfor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function viewCheckout()
    {
        $cartId = Cart::where('user_id', session('userData')->id)->first()->id;
        $cartItems = CartItem::where('cart_id', $cartId)->get();
        $totalPrice = 0;
        $user = session('userData');
        $userInfor = UserInfor::where('user_id', $user->id)->first();
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->product->price * $cartItem->quantity;
        }
        if ($totalPrice <= 0) {
            return redirect()->route('shop')->with('error', 'Không thể thanh toán vì giỏ hàng trống');
        }
        return view('cms.checkout.checkout', compact('cartItems', 'totalPrice', 'cartId', 'userInfor'));
    }

    public function orders(PaymentRequest $request)
    {
        DB::beginTransaction();
        try {
            $cartId = Cart::where('user_id', session('userData')->id)->first()->id;
            $cartItems = CartItem::with('product')->where('cart_id', $cartId)->get();
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

                // ✅ Xử lý từng sản phẩm trong giỏ
                foreach ($cartItems as $cartItem) {
                    // Tạo order item
                    $orderItem = OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'size' => $cartItem->size,
                    ]);
                    $product = $cartItem->product;

                    if ($product->is_free_size) {
                        // ✅ Nếu là freesize: trừ trực tiếp quantity tổng
                        $product->quantity -= $cartItem->quantity;
                        if ($product->quantity < 0) {
                            throw new \Exception('Số lượng sản phẩm không đủ.');
                        }
                        $product->save();
                    } else {
                        // ✅ Nếu có size: trừ ở bảng product_sizes
                        $productSize = ProductSize::where('product_id', $product->id)
                            ->where('size', $cartItem->size)
                            ->first();

                        if (!$productSize) {
                            throw new \Exception('Không tìm thấy kích thước phù hợp cho sản phẩm.');
                        }

                        if ($productSize->quantity < $cartItem->quantity) {
                            throw new \Exception("Số lượng size {$cartItem->size} của sản phẩm không đủ.");
                        }

                        // Trừ size
                        $productSize->quantity -= $cartItem->quantity;
                        $productSize->save();

                        // ✅ Cập nhật lại tổng số lượng sản phẩm
                        $product->quantity = ProductSize::where('product_id', $product->id)->sum('quantity');
                        $product->save();
                    }

                    // ✅ Xóa khỏi giỏ
                    $cartItem->delete();
                }

                DB::commit();
                $orderWithItems = Order::with('orderItems.product')->find($order->id);
                return view('cms.checkout.payment_success', compact('orderWithItems', 'order'));
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
            DB::beginTransaction();
            try {
                $userId = session('userData')->id;
                $cart = Cart::where('user_id', $userId)->first();
                $cartItems = CartItem::with('product')->where('cart_id', $cart->id)->get();

                // Tạo đơn hàng
                $order = Order::create([
                    'user_id' => $userId,
                    'status' => 'pending',
                    'payment' => 'vnpay',
                    'phone' => session('orderData')['phone'],
                    'address' => session('orderData')['address'],
                    'name' => session('orderData')['name'],
                    'email' => session('orderData')['email'],
                    'total_price' => session('orderData')['total_price'],
                ]);

                foreach ($cartItems as $cartItem) {
                    // Tạo từng mục đơn hàng
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'size' => $cartItem->size,
                    ]);

                    // Trừ số lượng sản phẩm
                    $product = $cartItem->product;

                    if ($product->is_free_size) {
                        // Nếu là freesize → trừ trực tiếp từ sản phẩm
                        $product->decrement('quantity', $cartItem->quantity);
                    } else {
                        // Nếu có size → trừ từ bảng ProductSize
                        $size = ProductSize::where('product_id', $product->id)
                            ->where('size', $cartItem->size)
                            ->first();

                        if ($size) {
                            $size->decrement('quantity', $cartItem->quantity);
                        }

                        $totalQuantity = ProductSize::where('product_id', $product->id)->sum('quantity');
                        $product->update(['quantity' => $totalQuantity]);
                    }

                    // Xóa sản phẩm khỏi giỏ
                    $cartItem->delete();
                }

                DB::commit();

                $orderWithItems = Order::with('orderItems.product')->find($order->id);
                return view('cms.checkout.payment_success', compact('orderWithItems', 'order'));
            } catch (\Throwable $e) {
                DB::rollBack();
                return view('cms.checkout.payment_failed')->with('error', 'Lỗi xử lý đơn hàng: ' . $e->getMessage());
            }
        }

        if ($vnp_ResponseCode === null) {
            return view('cms.cart.cart');
        }

        return view('cms.checkout.payment_failed');
    }
}

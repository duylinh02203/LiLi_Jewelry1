<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($request->product_id);
            $userId = session('userData')->id;
            $cart = Cart::where('user_id', $userId)->first();
            if (!$cart) {
                $cart = Cart::create([
                    'user_id' => $userId,
                ]);
            }
            $productInCart = CartItem::where('product_id', $product->id)
                ->where('cart_id', $cart->id)
                ->where('size', $request->size ?? '')
                ->first();
            if ($productInCart) {
                $productInCart->update([
                    'quantity' => $productInCart->quantity + ($request->quantity ?? 1),
                ]);
            } else {
                $cartItem = CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'size' => $request->size ?? '',
                    'quantity' => $request->quantity ?? 1,
                ]);
            }
            DB::commit();
            $cartCount = CartItem::where('cart_id', $cart->id)->sum('quantity');
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm vào giỏ hàng thành công',
                'cart_count' => $cartCount,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Không thêm được vào giỏ hàng',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $size = $request->size ?? '';
            $quantity = $request->quantity ?? '';
            $cartItem = CartItem::find($request->id);
            $cartItem->update([
                'quantity' => $quantity == '' ? $cartItem->quantity : $quantity,
                'size' => $size == '' ? $cartItem->size : $size,
            ]);
            DB::commit();
            $cartCount = CartItem::where('cart_id', $cartItem->cart_id)->sum('quantity');
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
                'cart_count' => $cartCount,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Không cập nhật được',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function cart()
    {
        $cartId = Cart::where('user_id', session('userData')->id)->first()->id;
        $cartItems = CartItem::with([
            'product.images',
            'product.sizes',
            'product.firstImage',
            'product.category',
        ])
            ->where('cart_id', $cartId)
            ->get();
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->product->price * $cartItem->quantity;
        }
        return view('cms.cart.cart', compact('cartItems', 'totalPrice'));
    }

    public function removeCartItem(Request $request)
    {
        DB::beginTransaction();
        try {
            $cartItem = CartItem::find($request->id);
            $cartItem->delete();
            $cartCount = CartItem::where('cart_id', $cartItem->cart_id)->sum('quantity');
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công sản phẩm khỏi giỏ hàng',
                'cart_count' => $cartCount,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Không xóa được',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function removeAllCartItem(Request $request)
    {
        DB::beginTransaction();
        try {
            $cartId = Cart::where('user_id', session('userData')->id)->first()->id;
            $cartItems = CartItem::where('cart_id', $cartId)->delete();
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công tất cả sản phẩm khỏi giỏ hàng',
                'cart_count'   => 0,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Không xóa được',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($request->product_id);
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sản phẩm không tồn tại.'
                ], 404);
            }

            $userId = session('userData')->id;
            $cart = Cart::firstOrCreate(['user_id' => $userId]);

            $requestedQty = $request->quantity ?? 1;
            $size = $request->size ?? '';

            if (!$product->is_free_size) {
                // !=freeSize
                $productSize = ProductSize::where('product_id', $product->id)
                    ->where('size', $size)
                    ->first();

                if (!$productSize) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Size không hợp lệ.',
                    ], 400);
                }

                $availableQty = $productSize->quantity;
                $productInCart = CartItem::where('product_id', $product->id)
                    ->where('cart_id', $cart->id)
                    ->where('size', $size)
                    ->first();

                $existingQty = $productInCart->quantity ?? 0;
                $totalRequested = $existingQty + $requestedQty;
                if ($totalRequested > $availableQty) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Số lượng yêu cầu vượt quá số lượng còn lại cho size này.',
                    ], 400);
                }

                if ($productInCart) {
                    $productInCart->update([
                        'quantity' => $totalRequested,
                    ]);
                } else {
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $product->id,
                        'size' => $size,
                        'quantity' => $requestedQty,
                    ]);
                }
            } else {
                // freeSize
                $productInCart = CartItem::where('product_id', $product->id)
                    ->where('cart_id', $cart->id)
                    ->first();
                $existingQty = $productInCart->quantity ?? 0;
                $totalRequested = $existingQty + $requestedQty;

                if ($totalRequested > $product->quantity) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Số lượng yêu cầu vượt quá số lượng sản phẩm còn lại.',
                    ], 400);
                }

                if ($productInCart) {
                    $productInCart->update([
                        'quantity' => $totalRequested,
                    ]);
                } else {
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $product->id,
                        'size' => '',
                        'quantity' => $requestedQty,
                    ]);
                }
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
            $newSize = $request->size ?? '';
            $newQuantity = $request->quantity ?? '';
            $cartItem = CartItem::findOrFail($request->id);
            $product = Product::findOrFail($cartItem->product_id);
            $currentQuantity = $cartItem->quantity;
            $updatedQuantity = $newQuantity === '' ? $currentQuantity : intval($newQuantity);

            if ($updatedQuantity < 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Số lượng phải lớn hơn 0.',
                ], 400);
            }

            if (!$product->is_free_size) {
                $oldSize = $cartItem->size;
                $sizeToUpdate = $newSize ?: $oldSize;

                $productSize = ProductSize::where('product_id', $product->id)
                    ->where('size', $sizeToUpdate)
                    ->first();

                if (!$productSize) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Size không hợp lệ hoặc không tồn tại.',
                    ], 400);
                }

                $existingQtySameSize = CartItem::where('product_id', $product->id)
                    ->where('cart_id', $cartItem->cart_id)
                    ->where('size', $sizeToUpdate)
                    ->where('id', '!=', $cartItem->id)
                    ->sum('quantity');

                $totalRequested = $existingQtySameSize + $updatedQuantity;

                if ($totalRequested > $productSize->quantity) {
                    // Nếu đổi size và không đủ số lượng → giữ nguyên size cũ
                    // Nếu chỉ thay đổi số lượng vượt quá thì trả về số lượng tối đa
                    if ($sizeToUpdate !== $oldSize) {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Size '$sizeToUpdate' không đủ hàng. Đã giữ lại size cũ '$oldSize'.",
                            'revert_size' => $oldSize,
                        ], 400);
                    } else {
                        $maxQty = max(0, $productSize->quantity - $existingQtySameSize);
                        $cartItem->update([
                            'quantity' => $maxQty,
                        ]);
                        DB::commit();
                        $cartCount = CartItem::where('cart_id', $cartItem->cart_id)->sum('quantity');
                        return response()->json([
                            'status' => 'error',
                            'message' => "Số lượng vượt quá tồn kho. Đã cập nhật về tối đa là $maxQty.",
                            'cart_count' => $cartCount,
                            'max_quantity' => $maxQty,
                        ], 400);
                    }
                }
                // Cập nhật size và số lượng mới nếu hợp lệ
                $cartItem->update([
                    'quantity' => $updatedQuantity,
                    'size' => $sizeToUpdate,
                ]);
            } else {
                // Freesize
                $existingQty = CartItem::where('product_id', $product->id)
                    ->where('cart_id', $cartItem->cart_id)
                    ->where('id', '!=', $cartItem->id)
                    ->sum('quantity');

                $totalRequested = $existingQty + $updatedQuantity;

                if ($totalRequested > $product->quantity) {
                    $maxQty = max(0, $product->quantity - $existingQty);
                    $cartItem->update([
                        'quantity' => $maxQty,
                    ]);
                    DB::commit();
                    $cartCount = CartItem::where('cart_id', $cartItem->cart_id)->sum('quantity');
                    return response()->json([
                        'status' => 'error',
                        'message' => "Số lượng vượt quá tồn kho. Đã cập nhật về tối đa là $maxQty.",
                        'cart_count' => $cartCount,
                        'max_quantity' => $maxQty,
                    ], 400);
                }

                $cartItem->update([
                    'quantity' => $updatedQuantity,
                ]);
            }

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
        $cart = Cart::where('user_id', session('userData')->id)->first();
        if (!$cart) {
            $cart = Cart::create([
                'user_id' => session('userData')->id
            ]);
        }
        $cartId = $cart->id;
        $cartItems = CartItem::with([
            'product.images',
            'product.sizes',
            'product.firstImage',
            'product.category',
        ])
            ->where('cart_id', $cartId)
            ->get();

        $totalPrice = 0;
        $cartNotices = [];
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            if (!$product) {
                // Sản phẩm đã bị xóa khỏi hệ thống
                $cartNotices[] = "Sản phẩm trong giỏ đã bị xóa khỏi hệ thống.";
                $cartItem->delete();
                continue;
            }
            if (!$product->is_free_size) {
                $productSize = $product->sizes->where('size', $cartItem->size)->first();
                $stock = $productSize ? $productSize->quantity : 0;
                if ($stock <= 0) {
                    $cartNotices[] = "Sản phẩm {$product->name} (size {$cartItem->size}) đã hết hàng và bị xóa khỏi giỏ hàng.";
                    $cartItem->delete();
                    continue;
                }
            } else {
                $stock = $product->quantity;
                if ($stock <= 0) {
                    $cartNotices[] = "Sản phẩm {$product->name} đã hết hàng và bị xóa khỏi giỏ hàng.";
                    $cartItem->delete();
                    continue;
                }
            }
            $totalPrice += $product->price * $cartItem->quantity;
        }
        // Lấy lại cartItems sau khi có thể đã xóa bớt
        $cartItems = CartItem::with([
            'product.images',
            'product.sizes',
            'product.firstImage',
            'product.category',
        ])->where('cart_id', $cartId)->get();
        return view('cms.cart.cart', compact('cartItems', 'totalPrice', 'cartNotices'));
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

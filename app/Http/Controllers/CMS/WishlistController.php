<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function viewWishlist()
    {
        if (!session()->has('userData')) {
            return view('cms.wishlist.wishlist')->with([
                'wishlists' => collect(),
                'message' => 'Bạn cần đăng nhập để xem danh sách yêu thích.'
            ]);
        }
        $wishlists = Wishlist::where('user_id', session('userData')->id)->with('product')->get();
        $wishlistCount = Wishlist::where('user_id', session('userData')->id)->count();
        return view('cms.wishlist.wishlist', compact('wishlists','wishlistCount'));
    }
    public function addWishlist(Request $request)
    {

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        if (!session()->has('userData')) {
            return response()->json(['status' => 'error', 'message' => 'Bạn cần đăng nhập để yêu thích']);
        }
        $userId = session('userData')->id;
        $productId = $request->product_id;

        $existingWishlist = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingWishlist) {
            $wishlistCount = Wishlist::where('user_id', $userId)->count();
            return response()->json(['status' => 'info', 'message' => 'Sản phẩm đã có trong danh sách yêu thích!', 'wishlist_count' => $wishlistCount]);
        }

        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
        $wishlistCount = Wishlist::where('user_id', $userId)->count();
        return response()->json(['status' => 'success', 'message' => 'Đã thêm vào danh sách yêu thích!', 'wishlist_count' => $wishlistCount]);
    }

    public function remove($id)
    {
        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', session('userData')->id)
            ->firstOrFail();
        $wishlist->delete();
        return redirect()->back();
    }
}

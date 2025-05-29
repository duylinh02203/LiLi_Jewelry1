<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function ProductReview()
    {   
        $productReviews = ProductReview::with('user', 'product')->paginate(5);
        return view('admin.reviews.product_review',compact('productReviews'));
    }

    public function destroy($id)
    {
        $productReview = ProductReview::findOrFail($id);
        $productReview->delete();
        return redirect()->route('admin.review.ProductReview')->with('success', 'Xóa đánh giá thành công.');
    }

    public function detail($id)
    {
        $productReview = ProductReview::with('user', 'product')->findOrFail($id);
        return view('admin.reviews.product_review_detail', compact('productReview'));
    }

    public function searchReview(Request $request)
    {
        $search = $request->input('search');
        $productReviews = ProductReview::with('user', 'product')
            ->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('product', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate(5);

        return view('admin.reviews.product_review', compact('productReviews'));
    }
}

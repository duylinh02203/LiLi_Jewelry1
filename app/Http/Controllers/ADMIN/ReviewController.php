<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function ProductReview(Request $request)
    {
        $search = $request->input('search');
        $rating = $request->input('rating');

        $query = ProductReview::with('user', 'product');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->orWhereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'LIKE', "%{$search}%");
                })
                    ->orWhereHas('product', function ($q3) use ($search) {
                        $q3->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        if ($rating && $rating !== 'all') {
            $query->where('rating', '=', (int) $rating);
        }

        $productReviews = $query->orderBy('created_at', 'desc')->paginate(5);

        return view('admin.reviews.product_review', compact('productReviews', 'search', 'rating'));
    }



    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $productReview = ProductReview::findOrFail($id);
            $productReview->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Xóa đánh giá thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.category.index')->with('error', 'Xóa đánh giá thất bại !');
        }
    }

    public function detail($id)
    {
        $productReview = ProductReview::with('user', 'product')->findOrFail($id);
        $productReview->update([
            'status' => 'inactive',
        ]);
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

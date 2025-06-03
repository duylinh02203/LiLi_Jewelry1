<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReviewController extends Controller
{
    public function index()
    {
        return view('cms.product-review.index');
    }

    public function create(Request $request)
    {
        DB::beginTransaction();

        try {
            $userData = session('userData');
            $validated = $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|min:10',
            ]);

            $userId = $userData->id;
            $isReview = ProductReview::where('user_id', $userId)
                ->where('product_id', $validated['product_id'])
                ->first();

            if ($isReview) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn đã đánh giá sản phẩm này rồi!',
                ]);
            }

            $data = [
                'user_id' => $userId,
                'product_id' => $validated['product_id'],
                'comment' => $validated['comment'],
                'rating' => $validated['rating'],
            ];

            ProductReview::create($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Đánh giá đã được thêm thành công!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi hệ thống!',
            ]);
        }
    }

    public function edit($id)
    {
        return view('cms.product-review.edit', compact('id'));
    }

    public function destroy($id)
    {
        $productReview = ProductReview::findOrFail($id);
        $productReview->delete();
        return redirect()->back()->with('success', 'Xóa thành công bình luận của bạn !');
    }
}

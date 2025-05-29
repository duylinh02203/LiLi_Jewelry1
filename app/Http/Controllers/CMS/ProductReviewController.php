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
        if (!session()->has('userData')) {
            return response()->json(['status' => 'error', 'message' => 'Bạn cần đăng nhập để đánh giá sản phẩm.']);
        }

        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:3|max:500',
        ], [
            'rating.required' => 'Bạn cần chọn xếp hạng.',
            'comment.required' => 'Bạn cần nhập bình luận.',
            'comment.min' => 'Bình luận cần ít nhất 3 ký tự.',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'product_id' => $validated['product_id'],
                'user_id' => session('userData')->id,
                'comment' => $validated['comment'],
                'rating' => $validated['rating'],
            ];
            ProductReview::create($data);
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Đánh giá sản phẩm thành công!']);
        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->getCode() === '23000') {
                return response()->json(['status' => 'error', 'message' => 'Bạn đã đánh giá sản phẩm này rồi!']);
            }
            return response()->json(['status' => 'error', 'message' => 'Đã xảy ra lỗi khi tạo đánh giá!']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Lỗi hệ thống!']);
        }
    }


    public function edit($id)
    {
        return view('cms.product-review.edit', compact('id'));
    }
}

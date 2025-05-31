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
            $data = [
                'product_id' => $request->product_id,
                'user_id' => session('userData')->id,
                'comment' => $request->comment,
                'rating' => $request->rating,
            ];

            ProductReview::create($data);
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Đánh giá đã được thêm thành công!',
            ]);
        } catch (QueryException $e) {
            DB::rollBack();

            if ($e->getCode() === '23000') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn đã đánh giá sản phẩm này rồi!',
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi khi tạo đánh giá!',
            ]);
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
}

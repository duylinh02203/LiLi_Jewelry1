<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductReview;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function shop(Request $request)
    {
        $page = $request->query('page', 1);
        $size = $request->query('size', 5);
        $sort = $request->query('sort', 'newest');
        $search = $request->query('q', '');
        $categorySlug = (array) $request->query('category', []);
        $priceRanges = (array) $request->query('price', []);
        $genders = (array) $request->query('gender', []);

        $categories = Category::all();

        $query = Product::with('images')
            ->when($categorySlug, function ($q) use ($categorySlug) {
                $q->whereHas('category', function ($subQuery) use ($categorySlug) {
                    $subQuery->whereIn('slug', $categorySlug);
                });
            })
            ->when($genders, fn($q) => $q->whereIn('gender', $genders))
            ->when($priceRanges, function ($q) use ($priceRanges) {
                $q->where(function ($subQuery) use ($priceRanges) {
                    foreach ($priceRanges as $range) {
                        if (strpos($range, ',') !== false) {
                            [$from, $to] = explode(',', $range);
                            $subQuery->orWhereBetween('price', [(float) $from, (float) $to]);
                        }
                    }
                });
            })
            ->when($search, fn($q) => $q->where('name', 'like', '%' . $search . '%'));

        match ($sort) {
            'newest'     => $query->orderBy('created_at', 'desc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->orderBy('price', 'asc'),
        };
        $products = $query->paginate($size)->appends($request->query());

        return view('cms.shop.shop', compact(
            'products',
            'categories',
            'page',
            'size',
            'sort',
            'search',
            'priceRanges',
            'categorySlug',
            'genders'
        ));
    }



    public function productDetails($slug)
    {
        $product = Product::with('images', 'category')->where('slug', $slug)->firstOrFail();
        $productReviews = $product->reviews()->with('user')->get();
        $reviewCount = $productReviews->count();
        $ratings = ProductReview::where('product_id', $product->id)
            ->select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->pluck('total', 'rating')
            ->toArray();
        $tbRating = ProductReview::where('product_id', $product->id)->avg('rating');
        $roundTbRating = round($tbRating);
        $productSizes = ProductSize::where('product_id', $product->id)->get();
        $relatedProducts = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(6)
            ->get();
        return view('cms.show.show', compact('product', 'relatedProducts', 'productSizes', 'productReviews', 'reviewCount', 'ratings','roundTbRating'));
    }
}

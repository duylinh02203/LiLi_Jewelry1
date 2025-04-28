<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    // Các field cho phép mass assign
    protected $fillable = [
        'name',
        'description',
        'price',
        'listed_price',
        'status',
        'slug',
        'category_id',
    ];

    // Một sản phẩm có nhiều ảnh
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Nếu cần: Một sản phẩm thuộc về một danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

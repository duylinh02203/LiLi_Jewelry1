<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'product_images';

    // Các field cho phép mass assign
    protected $fillable = [
        'product_id',
        'image',
    ];

    // Một ảnh thuộc về một sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

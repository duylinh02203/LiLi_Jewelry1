<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory, HasSlug;

    public $fillable = [
        'id',
        'name',
        'description',
        'price',
        'listed_price',
        'status',
        'slug',
        'quantity',
        'category_id',
        'gender'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    // Lấy danh mục mà sản phẩm thuộc về
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    // Lấy ảnh mà sản phẩm thuộc về

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function firstImage()
    {
        return $this->hasOne(ProductImage::class)->orderBy('id');
    }
}

<?php

namespace App\Models;

use App\Http\Controllers\CMS\ProductReviewController;
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
        'category_id',
        'gender',
        'quantity',
        'is_free_size',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function firstImage()
    {
        return $this->hasOne(ProductImage::class)->orderBy('id');
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}

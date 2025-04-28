<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    // public $timestamps = false;
    protected $table = 'categories';// ten bang trong csdl
    protected $primaryKey = 'id';// khoa chinh laravel nhan id la khoa chinh
    protected $fillable=['id','name','description'];
}

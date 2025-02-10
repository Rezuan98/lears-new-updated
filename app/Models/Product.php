<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVarient;
use App\Models\GalleryImage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'slug',
        'product_image',
        'product_code',
        'category_id',
        'subcategory_id',
        'brand_id',
        'unit_id',
        'discount_type',
        'discount_amount',
        'tags',
        'sale_price',
        'description',
        'status'
    ];


    // Define relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVarient::class);
    }

    public function galleryImages()
    {
        return $this->hasMany(GalleryImage::class);
    }

    
}

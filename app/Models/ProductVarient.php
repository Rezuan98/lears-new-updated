<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;


class ProductVarient extends Model
{
    use HasFactory;
    protected $table = 'product_varients';
    protected $fillable = [
        'product_id', 'color_id', 'size_id', 
        'stock_quantity', 'variant_price', 'sku', 'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'varient_id', 'id');
    }


}

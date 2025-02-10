<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'user_id', 'subtotal', 'shipping_charge', 
        'tax', 'total', 'payment_method', 'transaction_id',
        'payment_status', 'order_status', 'name', 'email', 
        'phone', 'address', 'city', 'postal_code', 'order_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber()
    {
        $lastOrder = self::latest()->first();
        $orderNumber = $lastOrder ? intval(substr($lastOrder->order_number, -6)) + 1 : 1;
        return 'ORD' . str_pad($orderNumber, 6, '0', STR_PAD_LEFT);
    }
}

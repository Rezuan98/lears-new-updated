<?php 
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVarient;

class CartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $cartItems = [];

            if (auth()->check()) {
                // Fetch cart items from database for authenticated users
                $cartItems = Cart::where('user_id', auth()->id())
                    ->with(['product', 'variant'])
                    ->get();
            } else {
                // Fetch cart items from session for unauthenticated users
                $cartItems = collect(session('cart', []))->map(function ($item) {
                    return (object)[
                        'id' => $item['product_id'] . '-' . $item['varient_id'],
                        'product' => Product::find($item['product_id']),
                        'variant' => ProductVarient::find($item['varient_id']),
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ];
                });
            }

            $subtotal = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            // Share cart data with all views
            $view->with('sharedCartItems', $cartItems);
            $view->with('sharedCartSubtotal', $subtotal);
        });
    }
}

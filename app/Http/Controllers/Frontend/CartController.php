<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVarient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            // For authenticated users - get from database
            $cartItems = Cart::with([
                'product',
                'variant.color',
                'variant.size'
            ])->where('user_id', Auth::id())
              ->get();
            
            $cartCount = $cartItems->sum('quantity');
        } else {
            // For guests - get from session
            $sessionCart = session('cart', []);
            
            $cartItems = collect($sessionCart)->map(function ($item, $key) {
                $product = Product::find($item['product_id']);
                $variant = ProductVarient::with(['color', 'size'])->find($item['varient_id']);
                
                return (object)[
                    'id' => $key,
                    'product' => $product,
                    'variant' => $variant,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ];
            });
            
            $cartCount = $cartItems->sum('quantity');
        }
    
       
    
        return view('frontend.pages.cart', compact(
            'cartItems', 
            'cartCount', 
            
        ));
    }
    // public function viewCart()
    // {
    //     if (Auth::check()) {
    //         // For authenticated users - get from database
    //         $cartItems = Cart::with([
    //             'product',
    //             'variant',
    //             'variant.color',
    //             'variant.size'
    //         ])->where('user_id', Auth::id())
    //           ->get();
            
    //         $cartCount = $cartItems->sum('quantity');
    //     } else {
    //         // For guests - get from session
    //         $sessionCart = session('cart', []);
    //         $cartItems = collect($sessionCart)->map(function ($item, $key) {
    //             $product = Product::find($item['product_id']);
    //             $variant = ProductVarient::with(['color', 'size'])->find($item['varient_id']);
                
    //             return (object)[
    //                 'id' => $key,
    //                 'product' => $product,
    //                 'variant' => $variant,
    //                 'quantity' => $item['quantity'],
    //                 'price' => $item['price']
    //             ];
    //         });
            
    //         $cartCount = $cartItems->sum('quantity');
    //     }
    //     dd($cartItems );
    
    //     return view('frontend.pages.cart', compact('cartItems', 'cartCount'));
    // }

    public function addToCart(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'varient_id' => 'required|exists:product_varients,id',
                'quantity' => 'required|integer|min:1',
                'price' => 'required|numeric'
            ]);

            if (Auth::check()) {
                // For authenticated users - store in database
                $cartItem = Cart::where([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'varient_id' => $request->varient_id,
                ])->first();

                if ($cartItem) {
                    // Update quantity if item exists
                    $cartItem->quantity += $request->quantity;
                    $cartItem->save();
                } else {
                    // Create new cart item
                    Cart::create([
                        'user_id' => Auth::id(),
                        'product_id' => $request->product_id,
                        'varient_id' => $request->varient_id,
                        'quantity' => $request->quantity,
                        'price' => $request->price
                    ]);
                }

                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            } else {
                // For unauthenticated users - store in session
                $cart = session()->get('cart', []);
                
                $itemKey = $request->product_id . '-' . $request->varient_id;
                
                if (isset($cart[$itemKey])) {
                    // Update quantity if item exists
                    $cart[$itemKey]['quantity'] += $request->quantity;
                } else {
                    // Add new item
                    $cart[$itemKey] = [
                        'product_id' => $request->product_id,
                        'varient_id' => $request->varient_id,
                        'quantity' => $request->quantity,
                        'price' => $request->price
                    ];
                }
                
                session()->put('cart', $cart);
                
                $cartCount = collect($cart)->sum('quantity');
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'cartCount' => $cartCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart: ' . $e->getMessage()
            ], 500);
        }
    }






    public function updateCart(Request $request)
{
    try {
        if (Auth::check()) {
            $cart = Cart::where([
                'id' => $request->cart_id,
                'user_id' => Auth::id()
            ])->first();

            if (!$cart) {
                return response()->json(['success' => false, 'message' => 'Cart item not found']);
            }

            $cart->quantity = $request->quantity;
            $cart->save();

            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            $sessionCart = session()->get('cart', []);
            
            if (!isset($sessionCart[$request->cart_id])) {
                return response()->json(['success' => false, 'message' => 'Cart item not found']);
            }

            $sessionCart[$request->cart_id]['quantity'] = $request->quantity;
            session()->put('cart', $sessionCart);
            
            $cartCount = collect($sessionCart)->sum('quantity');
        }

        return response()->json([
            'success' => true,
            'cartCount' => $cartCount,
            'itemTotal' => $request->quantity * (Auth::check() ? $cart->price : $sessionCart[$request->cart_id]['price'])
        ]);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

public function removeFromCart(Request $request)
{
    try {
        if (Auth::check()) {
            $cart = Cart::where([
                'id' => $request->cart_id,
                'user_id' => Auth::id()
            ])->first();

            if ($cart) {
                $cart->delete();
                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            } else {
                return response()->json(['success' => false, 'message' => 'Cart item not found']);
            }
        } else {
            $sessionCart = session()->get('cart', []);
            if (isset($sessionCart[$request->cart_id])) {
                unset($sessionCart[$request->cart_id]);
                session()->put('cart', $sessionCart);
                $cartCount = collect($sessionCart)->sum('quantity');
            } else {
                return response()->json(['success' => false, 'message' => 'Cart item not found']);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed successfully',
            'cartCount' => $cartCount
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to remove item: ' . $e->getMessage()
        ], 500);
    }
}
    


public function fetchCartItems()
{
    if (auth()->check()) {
        // For authenticated users
        $cartItems = Cart::where('user_id', auth()->id())
            ->with(['product', 'variant'])
            ->get();
    } else {
        // For unauthenticated users
        $cartItems = collect(session('cart', []))->map(function ($item) {
            return (object)[
                'id' => $item['product_id'] . '-' . $item['varient_id'],
                'product_name' => Product::find($item['product_id'])->product_name ?? 'N/A',
                'product_image' => Product::find($item['product_id'])->product_image ?? 'default.png',
                'variant' => [
                    'color' => ProductVarient::find($item['varient_id'])->color->name ?? 'N/A',
                    'size' => ProductVarient::find($item['varient_id'])->size->name ?? 'N/A',
                ],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ];
        });
    }

    $subtotal = $cartItems->sum(function ($item) {
        return $item->quantity * $item->price;
    });

    return response()->json([
        'success' => true,
        'cartItems' => $cartItems,
        'subtotal' => $subtotal
    ]);
}





   

}

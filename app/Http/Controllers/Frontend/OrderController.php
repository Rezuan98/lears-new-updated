<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\OrderItem;


use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function shipping()
{
    if (Auth::check()) {
        $user = Auth::user();
        // For authenticated users - get cart from database
        $cartItems = Cart::where('user_id', Auth::id())
                       ->with('product', 'variant')
                       ->get();
    } else {
        $user = null;
        // For guest users - get cart from session
        $cart = session()->get('cart', []);
        
        // Debug cart structure
        // dd($cart); // Uncomment this to see your session cart structure
        
        // Get cart items from session and format them
        $cartItems = collect($cart)->map(function($item, $key) {
            return (object)[
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'product_id' => $item['product_id'],
                'varient_id' => $item['varient_id'],
                // Get product details
                'product' => Product::with(['variants'])->find($item['product_id']),
                // Get variant details
                'variant' => ProductVarient::with(['color', 'size'])->find($item['varient_id'])
            ];
        })->values();
    }

    // Redirect if cart is empty
    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')
                        ->with('error', 'Your cart is empty!');
    }

    // Get delivery location from session
    $delivery_location = session('delivery_location', 'inside');

    return view('frontend.pages.shipping', compact('user', 'cartItems', 'delivery_location'));
}

 


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string',
        'address' => 'required|string',
        'city' => 'required|string',
        'postal_code' => 'required|string',
        'payment_method' => 'required|in:cod',
    ]);

    try {
        DB::beginTransaction();

        // Generate unique session ID for each order for guest users
        $uniqueSessionId = !Auth::check() ? uniqid('guest_', true) : null;

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                           ->with(['product', 'variant'])
                           ->get();
        } else {
            $cart = session()->get('cart', []);
            
            $cartItems = collect($cart)->map(function($item) {
                $product = Product::with('variants')->find($item['product_id']);
                $variant = ProductVarient::with(['color', 'size'])->find($item['varient_id']);
                
                return (object)[
                    'product_id' => $item['product_id'],
                    'varient_id' => $item['varient_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'product' => $product,
                    'variant' => $variant
                ];
            });
        }

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
        $shipping = session('delivery_location') === 'inside' ? 50 : 110;
        $tax = $subtotal * 0.10;
        $total = $subtotal + $shipping + $tax;

        // Create order
        $order = new Order();
        $order->order_number = $this->generateOrderNumber();
        
        if (Auth::check()) {
            $order->user_id = Auth::id();
        } else {
            $order->session_id = $uniqueSessionId;
        }

        $order->subtotal = $subtotal;
        $order->shipping_charge = $shipping;
        $order->tax = $tax;
        $order->total = $total;
        $order->payment_method = $request->payment_method;
        $order->payment_status = 'pending';
        $order->order_status = 'pending';
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->city = $request->city;
        $order->postal_code = $request->postal_code;
        $order->order_notes = $request->order_notes;
        $order->save();

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'variant_id' => $item->varient_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->price * $item->quantity,
                'variant_color' => $item->variant->color->name ?? null,
                'variant_size' => $item->variant->size->name ?? null
            ]);

            // Update product stock
            $item->variant->decrement('stock_quantity', $item->quantity);
        }

        // Clear cart and sessions
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
            session()->forget('delivery_location');
            session()->forget('guest_order');
            
            // Keep order number temporarily for success page
            session()->flash('temp_order_number', $order->order_number);
        }

        DB::commit();

        return redirect()->route('order.success', $order->order_number)
                       ->with('success', 'Order placed successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Order creation failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong! Please try again.');
    }
}

public function success($orderNumber)
{
    if (!Auth::check() && !session()->has('temp_order_number')) {
        return redirect()->route('home')
                       ->with('error', 'Order not found!');
    }

    $order = Order::where('order_number', $orderNumber)
                 ->with(['items.product', 'items.variant'])
                 ->firstOrFail();

    // Clear temporary order session after showing success page
    session()->forget('temp_order_number');

    return view('frontend.pages.success_order', compact('order'));
}

private function generateOrderNumber()
{
    $prefix = 'ORD';
    $date = now()->format('ymd');
    $uniqueId = strtoupper(substr(uniqid(), -4));
    $timestamp = now()->format('His'); // Add hours, minutes, seconds
    
    return $prefix . $date . $timestamp . $uniqueId;
}

    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
                     ->with(['items.product', 'items.variant']);

        // Handle authentication check for order viewing
        if (Auth::check()) {
            $order = $order->where('user_id', Auth::id());
        } else {
            // For guest users, check session ID and stored order number
            $order = $order->where('session_id', session()->getId())
                         ->where('order_number', session('guest_order'));
        }

        $order = $order->firstOrFail();
        
        return view('frontend.order.show', compact('order'));
    }

    public function updatePaymentStatus(Request $request)
{
    try {
        $request->validate([
            'id' => 'required|exists:orders,id',
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        $order = Order::find($request->id);
        $order->payment_status = $request->payment_status;
        $order->save();

        return response()->json(['success' => true, 'message' => 'Payment status updated successfully!']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Failed to update payment status!']);
    }
}

}


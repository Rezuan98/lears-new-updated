<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        if (auth()->user()->wish->contains($product)) {
            auth()->user()->wish()->detach($product);
            $message = 'Product removed from wishlist';
        } else {
            auth()->user()->wish()->attach($product);
            $message = 'Product added to wishlist';
        }

        return back()->with('success', $message);
    }

    public function index()
    {
        $wishlist = auth()->user()->wishlist()->with('variants')->get();
        return view('frontend.wishlist.index', compact('wishlist'));
    }

}

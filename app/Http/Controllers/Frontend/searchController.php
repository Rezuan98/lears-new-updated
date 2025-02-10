<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class searchController extends Controller
{
  

    public function liveSearch(Request $request)
    {
        $query = $request->get('query', '');

        // Fetch products by product_name, tags, description, category name, or subcategory name
        $products = Product::with(['category', 'subcategory'])
            ->where('product_name', 'LIKE', "%{$query}%")
            ->orWhere('tags', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhereHas('category', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('subcategory', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->take(10) // Limit to 10 results
            ->get();

        return response()->json($products);
    }
   }


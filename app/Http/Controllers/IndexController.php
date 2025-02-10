<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVarient;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\GalleryImage;
use App\Models\Slider;

class IndexController extends Controller
{
    public function index(){

        $new_arrival = Product::where('category_id',1)->with('variants','galleryImages')->get();
        $best_selling = Product::where('category_id',5)->with('variants','galleryImages')->get();
      
        // $categoryNames = Category::where('status', 1)->limit(10)->get();
        $sliders = Slider::where('status', true)
        ->orderBy('order')
        ->get();


        
       
        
        return view('frontend.master.index', compact('new_arrival', 'best_selling','sliders'));

    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class CategoryProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //  $categories = Category::where('status', 1)->limit(10)->get();
         
        //   // Share categories across all views
        // View::composer('*', function ($view) use ($categories) {
        //     $view->with('categories', $categories);
        // });
        
    }
}

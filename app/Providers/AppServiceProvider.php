<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;
use App\Models\Category;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $settings = SiteSetting::first() ?? new SiteSetting();
            $view->with('settings', $settings);
                  
             $categories = Category::where('status', 1)->limit(10)->get();
            $view->with('categories', $categories);
      
        });
    }
}

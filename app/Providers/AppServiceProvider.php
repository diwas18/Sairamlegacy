<?php

namespace App\Providers;
use App\Models\Category;
use Illuminate\Support\Facades\View;

use Illuminate\Support\ServiceProvider;

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


    $categories = Category::orderBy('priority', 'desc')->get();
    View::share('categories', $categories);

    }
}

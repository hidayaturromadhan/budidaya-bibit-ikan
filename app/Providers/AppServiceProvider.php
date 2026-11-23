<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('layouts.app', function ($view) {
            $categories = \App\Models\FishSeed::where('is_active', true)->whereNotNull('category')->distinct()->pluck('category');
            $view->with('categories', $categories);
        });
    }
}

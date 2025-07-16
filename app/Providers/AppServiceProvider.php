<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\GoogleAnalytic;
use Illuminate\Support\ServiceProvider;
use View;
use Cart;

class AppServiceProvider extends ServiceProvider
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
        View::composer('*', function ($view) {
            $view->with('menuCategories', Category::where('status', 1)->where('parent_id', 0)->latest()->get());
            $view->with('cartProducts', Cart::getContent());
            $view->with('googleAnalytic', GoogleAnalytic::latest()->first());
            $view->with('generalSettingView', GeneralSetting::latest()->first());
        });
    }
}

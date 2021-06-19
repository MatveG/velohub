<?php

namespace App\Providers;

use App;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(resource_path() . '/admin/views', 'Admin');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        App\Models\Category::observe(App\Observers\CategoryObserver::class);
        App\Models\Feature::observe(App\Observers\FeatureObserver::class);
        App\Models\Product::observe(App\Observers\ProductObserver::class);
//        App\Models\Variant::observe(App\Observers\VariantObserver::class);
    }
}

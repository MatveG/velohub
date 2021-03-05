<?php

namespace App\Providers;

use App;
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
        foreach (glob(__DIR__.'/../Helpers/*.php') as $filename)
        {
            require_once $filename;
        }

        $this->loadViewsFrom(resource_path() . '/admin/views', 'Admin');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        App\Models\Category::observe(App\Observers\ProductObserver::class);
        App\Models\Category::observe(App\Observers\CategoryObserver::class);
        App\Models\Variant::observe(App\Observers\VariantObserver::class);

        App\View\Directives\WidgetDirectives::directives();

        App\View\Share\CartShare::share();
        App\View\Share\CategoryShare::share();
        App\View\Share\MenuShare::share();
    }
}

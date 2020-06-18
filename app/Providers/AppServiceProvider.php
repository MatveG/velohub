<?php

namespace App\Providers;

use App;
use App\Models\Category;
use App\Models\Product;
use App\Observers\ProductObserver;
use App\Widgets\Widget;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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

        // Register Widget class
        App::singleton('widget', function() { return new Widget(); });

        // Define path to Custom Views
        $this->loadViewsFrom(resource_path() . '/views/widgets', 'Widgets');
        $this->loadViewsFrom(resource_path() . '/admin/views', 'Admin');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Product::observe(App\Observers\ProductObserver::class);
        Category::observe(App\Observers\CategoryObserver::class);

        // Register Blade directive for Widget
        Blade::directive('widget', function ($name) {
            return "<?php echo app('widget')->show($name); ?>";
        });

    }
}

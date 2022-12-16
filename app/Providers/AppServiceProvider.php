<?php

namespace App\Providers;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Observers\ProductObserver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Blade::directive('routeactive', function ($route) {
            return "<?php echo Route::currentRouteNamed($route) ? 'class=\"active\"' : '' ?>";
        });

        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->isAdmin();
        });

        Product::observe(ProductObserver::class);
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}

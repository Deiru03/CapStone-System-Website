<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\AdminLayout;
use App\View\Layout\Admin;
use App\Http\Middleware\RedirectIfNotAdmin;

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
        Blade::component('admin-layout', AdminLayout::class);
        // Register the RedirectIfNotAdmin middleware
        $this->app['router']->aliasMiddleware('admin', RedirectIfNotAdmin::class);
    }
}

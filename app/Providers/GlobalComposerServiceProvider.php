<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class GlobalComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $userId = Auth::id();
            $site_settings = SiteSetting::where('u_id', $userId)->first();
            $view->with('site_settings', $site_settings);
            // $view->with('site_settings', SiteSetting::where('id','1')->first());
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\MenuPermission;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Force HTTPS in production
        if (app()->environment('production') && !app()->isLocal()) {
            URL::forceScheme('https');
        }
        // Share site-wide settings with all views
        View::composer('*', function ($view) {
            try {
                $siteSettings = Setting::allCached();
            } catch (\Throwable) {
                $siteSettings = [];
            }
            $view->with('siteSettings', $siteSettings);
        });

        // Share admin menu permissions with admin views
        View::composer('layouts.admin', function ($view) {
            $allowedMenus = [];
            if (auth()->check()) {
                $user = auth()->user();
                if ($user->isAdmin()) {
                    $allowedMenus = ['*']; // admin gets everything
                } else {
                    try {
                        $allowedMenus = MenuPermission::where('role', $user->role)
                            ->pluck('menu_key')
                            ->toArray();
                    } catch (\Throwable) {
                        $allowedMenus = [];
                    }
                }
            }
            $view->with('allowedMenus', $allowedMenus);
        });
    }
}

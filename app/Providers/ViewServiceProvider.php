<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
        try {
            if (Schema::hasTable('settings') && Schema::hasTable('menus')) {
                $settings = Setting::pluck('value', 'key')->toArray();
                $quick_links = Setting::select('key', 'display_name', 'value')->where('key', 'like', 'quick_link_%')->get();
                $useful_links = Setting::select('key', 'display_name', 'value')->where('key', 'like', 'useful_link_%')->get();

                $menus = Menu::where('status', 'active')->get();
                view()->composer('*', function ($view) use ($settings, $menus, $quick_links, $useful_links) {
                    $view->with('settings', $settings)
                        ->with('all_menus', $menus)
                        ->with('quick_links', $quick_links)
                        ->with('useful_links', $useful_links);
                });
            }
        } catch (\Exception $e) {
            // If the database isn't available yet (migrations not run or wrong connection),
            // avoid breaking the application bootstrap. Views will use fallbacks.
            return;
        }
    }
}

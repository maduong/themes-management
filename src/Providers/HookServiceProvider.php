<?php namespace Edutalk\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;
use Edutalk\Base\ThemesManagement\Hook\RegisterDashboardStats;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        add_action(EDUTALK_DASHBOARD_STATS, [RegisterDashboardStats::class, 'handle'], 23);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}

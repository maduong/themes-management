<?php namespace Edutalk\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class UpdateModuleServiceProvider extends ServiceProvider
{
    protected $module = 'edutalk-themes-management';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        register_module_update_batches('edutalk-themes-management', [

        ]);
    }

    protected function booted()
    {
        load_module_update_batches('edutalk-themes-management');
    }
}

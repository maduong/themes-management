<?php namespace Edutalk\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'edutalk-themes-management';

    /**
     * Bootstrap the application services.
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
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function booted()
    {
        /**
         * Now, just super admin can modify themes
         */
        acl_permission()
            ->registerPermission('View themes', 'view-themes', $this->module)
            ->registerPermission('View theme options', 'view-theme-options', $this->module)
            ->registerPermission('Update theme options', 'update-theme-options', $this->module);
    }
}

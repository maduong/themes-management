<?php namespace DummyNamespace\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = '{alias}';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}

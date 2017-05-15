<?php namespace Edutalk\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->generatorCommands();
        $this->otherCommands();
    }

    protected function generatorCommands()
    {
        $this->commands([
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeTheme::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeController::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeView::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeProvider::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeCommand::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeCriteria::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeDataTable::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeFacade::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeMiddleware::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeModel::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeRepository::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeRequest::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeService::class,
            \Edutalk\Base\ThemesManagement\Console\Generators\MakeSupport::class,
        ]);
    }

    protected function otherCommands()
    {
        $this->commands([
            \Edutalk\Base\ThemesManagement\Console\Commands\EnableThemeCommand::class,
            \Edutalk\Base\ThemesManagement\Console\Commands\DisableThemeCommand::class,
            \Edutalk\Base\ThemesManagement\Console\Commands\InstallThemeCommand::class,
            \Edutalk\Base\ThemesManagement\Console\Commands\UpdateThemeCommand::class,
            \Edutalk\Base\ThemesManagement\Console\Commands\UninstallThemeCommand::class,
            \Edutalk\Base\ThemesManagement\Console\Commands\GetAllThemesCommand::class,
        ]);
    }
}

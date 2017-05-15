<?php namespace Edutalk\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;
use Edutalk\Base\ThemesManagement\Models\Theme;
use Edutalk\Base\ThemesManagement\Models\ThemeOption;
use Edutalk\Base\ThemesManagement\Repositories\Contracts\ThemeOptionRepositoryContract;
use Edutalk\Base\ThemesManagement\Repositories\Contracts\ThemeRepositoryContract;
use Edutalk\Base\ThemesManagement\Repositories\ThemeOptionRepository;
use Edutalk\Base\ThemesManagement\Repositories\ThemeOptionRepositoryCacheDecorator;
use Edutalk\Base\ThemesManagement\Repositories\ThemeRepository;
use Edutalk\Base\ThemesManagement\Repositories\ThemeRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ThemeRepositoryContract::class, function () {
            $repository = new ThemeRepository(new Theme());

            if (config('edutalk-caching.repository.enabled')) {
                return new ThemeRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
        $this->app->bind(ThemeOptionRepositoryContract::class, function () {
            $repository = new ThemeOptionRepository(new ThemeOption());

            if (config('edutalk-caching.repository.enabled')) {
                return new ThemeOptionRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}

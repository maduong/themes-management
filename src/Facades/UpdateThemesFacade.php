<?php namespace Edutalk\Base\ThemesManagement\Facades;

use Illuminate\Support\Facades\Facade;
use Edutalk\Base\ThemesManagement\Support\UpdateThemesSupport;

class UpdateThemesFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return UpdateThemesSupport::class;
    }
}

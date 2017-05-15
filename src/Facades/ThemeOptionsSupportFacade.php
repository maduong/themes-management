<?php namespace Edutalk\Base\ThemesManagement\Facades;

use Illuminate\Support\Facades\Facade;
use Edutalk\Base\ThemesManagement\Support\ThemeOptionsSupport;

class ThemeOptionsSupportFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemeOptionsSupport::class;
    }
}

<?php namespace Edutalk\Base\ThemesManagement\Facades;

use Illuminate\Support\Facades\Facade;
use Edutalk\Base\ThemesManagement\Support\ThemesManagement;

class ThemesManagementFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemesManagement::class;
    }
}

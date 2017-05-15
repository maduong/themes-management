<?php namespace Edutalk\Base\ThemesManagement\Http\Controllers;

use Edutalk\Base\Http\Controllers\BaseAdminController;
use Illuminate\Support\Facades\Artisan;
use Edutalk\Base\ThemesManagement\Http\DataTables\ThemesListDataTable;

class ThemeController extends BaseAdminController
{
    protected $module = 'edutalk-themes-management';

    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            $this->getDashboardMenu($this->module);

            return $next($request);
        });
    }

    /**
     * Get index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(ThemesListDataTable $themesListDataTable)
    {
        $this->breadcrumbs->addLink(trans('edutalk-themes-management::base.themes'));
        $this->setPageTitle(trans('edutalk-themes-management::base.themes'));

        $this->dis['dataTable'] = $themesListDataTable->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, EDUTALK_THEMES_MANAGEMENT, 'index.get')->viewAdmin('list');
    }

    /**
     * Set data for DataTable plugin
     * @param ThemesListDataTable $themesListDataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function postListing(ThemesListDataTable $themesListDataTable)
    {
        return do_filter('datatables.edutalk-themes-management.index.post', $themesListDataTable, $this);
    }

    public function postChangeStatus($alias, $status)
    {
        $theme = get_theme_information($alias);

        if (!$theme) {
            return response_with_messages(trans('edutalk-themes-management::base.theme_not_exists'), true, \Constants::ERROR_CODE);
        }

        if (!$status) {
            return themes_management()->disableTheme($alias)->refreshComposerAutoload();
        } else {
            $check = check_module_require($theme);
            if ($check['error']) {
                return $check;
            }
            return themes_management()->enableTheme($alias)->refreshComposerAutoload();
        }
    }

    public function postInstall($alias)
    {
        $theme = get_theme_information($alias);

        if (!$theme) {
            return response_with_messages(trans('edutalk-themes-management::base.theme_not_exists'), true, \Constants::ERROR_CODE);
        }

        $check = check_module_require($theme);
        if ($check['error']) {
            return $check;
        }

        Artisan::call('theme:install', [
            'alias' => $alias
        ]);

        return response_with_messages(trans('edutalk-themes-management::base.theme_installed'));
    }

    public function postUpdate($alias)
    {
        $theme = get_theme_information($alias);

        if (!$theme) {
            return response_with_messages(trans('edutalk-themes-management::base.theme_not_exists'), true, \Constants::ERROR_CODE);
        }

        $check = check_module_require($theme);
        if ($check['error']) {
            return $check;
        }

        Artisan::call('theme:update', [
            'alias' => $alias
        ]);

        return response_with_messages(trans('edutalk-themes-management::base.theme_updated'));
    }

    public function postUninstall($alias)
    {
        $theme = get_theme_information($alias);

        if (!$theme) {
            return response_with_messages(trans('edutalk-themes-management::base.theme_not_exists'), true, \Constants::ERROR_CODE);
        }

        $check = check_module_require($theme);
        if ($check['error']) {
            return $check;
        }

        Artisan::call('theme:uninstall', [
            'alias' => $alias
        ]);

        return response_with_messages(trans('edutalk-themes-management::base.theme_uninstalled'));
    }
}

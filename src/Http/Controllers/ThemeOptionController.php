<?php namespace Edutalk\Base\ThemesManagement\Http\Controllers;

use Edutalk\Base\Http\Controllers\BaseAdminController;
use Edutalk\Base\ThemesManagement\Repositories\Contracts\ThemeOptionRepositoryContract;
use Edutalk\Base\ThemesManagement\Repositories\ThemeOptionRepository;

class ThemeOptionController extends BaseAdminController
{
    protected $module = 'edutalk-themes-management';

    /**
     * @param ThemeOptionRepository $repository
     */
    public function __construct(ThemeOptionRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->middleware(function ($request, $next) {
            $this->getDashboardMenu('edutalk-theme-options');
            $this->breadcrumbs->addLink(trans('edutalk-themes-management::base.theme_options'));

            return $next($request);
        });
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $this->setPageTitle(trans('edutalk-themes-management::base.theme_options'));

        return do_filter(BASE_FILTER_CONTROLLER, $this, Edutalk_THEME_OPTIONS, 'index.get')->viewAdmin('theme-options-index');
    }

    public function postIndex()
    {
        $data = $this->request->except([
            '_token',
            '_tab',
        ]);

        /**
         * Filter
         */
        $data = do_filter('theme-options.before-edit.post', $data, $this);

        $result = $this->repository->updateOptions($data);

        $msgType = !$result ? 'danger' : 'success';
        $msg = $result ? trans('edutalk-core::base.form.request_completed') : trans('edutalk-core::base.form.error_occurred');

        flash_messages()
            ->addMessages($msg, $msgType)
            ->showMessagesOnSession();

        do_action(BASE_ACTION_AFTER_UPDATE, Edutalk_THEME_OPTIONS, $data, $result);

        return redirect()->back();
    }
}

<?php namespace Edutalk\Base\ThemesManagement\Http\DataTables;

use Edutalk\Base\Http\DataTables\AbstractDataTables;
use Edutalk\Base\ThemesManagement\Facades\ThemesFacade;
use Yajra\Datatables\Engines\CollectionEngine;
use Yajra\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Engines\QueryBuilderEngine;

class ThemesListDataTable extends AbstractDataTables
{
    protected $repository;

    public function __construct()
    {
        $this->repository = ThemesFacade::getAllThemes(false);
    }

    /**
     * @return array
     */
    public function headings()
    {
        return [
            'thumbnail' => [
                'title' => trans('edutalk-themes-management::datatables.heading.thumbnail'),
                'width' => '15%',
            ],
            'name' => [
                'title' => trans('edutalk-themes-management::datatables.heading.name'),
                'width' => '20%',
            ],
            'description' => [
                'title' => trans('edutalk-themes-management::datatables.heading.description'),
                'width' => '40%',
            ],
            'actions' => [
                'title' => trans('edutalk-core::datatables.heading.actions'),
                'width' => '40%',
            ],
        ];
    }

    /**
     * @return array
     */
    public function columns()
    {
        return [
            ['data' => 'thumbnail', 'name' => 'thumbnail', 'searchable' => false, 'orderable' => false],
            ['data' => 'name', 'name' => 'name', 'searchable' => false, 'orderable' => false],
            ['data' => 'description', 'name' => 'description', 'searchable' => false, 'orderable' => false],
            ['data' => 'actions', 'name' => 'actions', 'searchable' => false, 'orderable' => false],
        ];
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->setAjaxUrl(route('admin::themes.index.post'), 'POST');

        return $this->view();
    }

    /**
     * @return CollectionEngine|EloquentEngine|QueryBuilderEngine|mixed
     */
    protected function fetchDataForAjax()
    {
        return datatable()->of($this->repository)
            ->rawColumns(['description', 'actions', 'thumbnail'])
            ->editColumn('description', function ($item) {
                return array_get($item, 'description') . '<br><br>'
                    . trans('edutalk-themes-management::datatables.author') . ': <b>' . array_get($item, 'author') . '</b><br>'
                    . trans('edutalk-themes-management::datatables.version') . ': <b>' . array_get($item, 'version', '...') . '</b>' . '<br>'
                    . trans('edutalk-themes-management::datatables.installed_version') . ': <b>' . (array_get($item, 'installed_version') ?: '...') . '</b>';
            })
            ->addColumn('thumbnail', function ($item) {
                $themeFolder = get_base_folder($item['file']);
                $themeThumbnail = $themeFolder . 'theme.jpg';
                if (!\File::exists($themeThumbnail)) {
                    $themeThumbnail = Edutalk_themes_path('default-thumbnail.jpg');
                }
                $imageData = base64_encode(\File::get($themeThumbnail));
                $src = 'data: ' . mime_content_type($themeThumbnail) . ';base64,' . $imageData;
                return '<img src="' . $src . '" alt="' . array_get($item, 'alias') . '" width="240" height="180" class="theme-thumbnail">';
            })
            ->addColumn('actions', function ($item) {
                $activeBtn = (!array_get($item, 'enabled')) ? form()->button(trans('edutalk-themes-management::datatables.active'), [
                    'title' => trans('edutalk-themes-management::datatables.active_this_theme'),
                    'data-ajax' => route('admin::themes.change-status.post', [
                        'module' => array_get($item, 'alias'),
                        'status' => 1,
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                ]) : '';
                $disableBtn = (array_get($item, 'enabled')) ? form()->button(trans('edutalk-themes-management::datatables.disable'), [
                    'title' => trans('edutalk-themes-management::datatables.disable_this_theme'),
                    'data-ajax' => route('admin::themes.change-status.post', [
                        'module' => array_get($item, 'alias'),
                        'status' => 0,
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline yellow-lemon btn-sm ajax-link',
                ]) : '';

                $installBtn = (array_get($item, 'enabled') && !array_get($item, 'installed')) ? form()->button(trans('edutalk-themes-management::datatables.install'), [
                    'title' => trans('edutalk-themes-management::datatables.install_this_theme'),
                    'data-ajax' => route('admin::themes.install.post', [
                        'module' => array_get($item, 'alias'),
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline blue btn-sm ajax-link',
                ]) : '';

                $updateBtn = (
                    array_get($item, 'enabled') &&
                    array_get($item, 'installed') &&
                    version_compare(array_get($item, 'installed_version'), array_get($item, 'version'), '<')
                )
                    ? form()->button(trans('edutalk-themes-management::datatables.update'), [
                        'title' => trans('edutalk-themes-management::datatables.update_this_theme'),
                        'data-ajax' => route('admin::themes.update.post', [
                            'module' => array_get($item, 'alias'),
                        ]),
                        'data-method' => 'POST',
                        'data-toggle' => 'confirmation',
                        'class' => 'btn btn-outline purple btn-sm ajax-link',
                    ])
                    : '';

                $uninstallBtn = (array_get($item, 'enabled') && array_get($item, 'installed')) ? form()->button(trans('edutalk-themes-management::datatables.uninstall'), [
                    'title' => trans('edutalk-themes-management::datatables.uninstall_this_theme'),
                    'data-ajax' => route('admin::themes.uninstall.post', [
                        'module' => array_get($item, 'alias'),
                    ]),
                    'data-method' => 'POST',
                    'data-toggle' => 'confirmation',
                    'class' => 'btn btn-outline red-sunglo btn-sm ajax-link',
                ]) : '';

                return $activeBtn . $disableBtn . $installBtn . $updateBtn . $uninstallBtn;
            });
    }
}

<?php namespace DummyNamespace\Http\Controllers\Pages;

use Edutalk\Base\Pages\Models\Contracts\PageModelContract;
use Edutalk\Base\Pages\Models\Page;
use Edutalk\Base\Pages\Repositories\Contracts\PageRepositoryContract;
use Edutalk\Base\Pages\Repositories\PageRepository;

use DummyNamespace\Http\Controllers\AbstractController;

class PageController extends AbstractController
{
    /**
     * @var Page
     */
    protected $page;

    /**
     * @param PageRepository $repository
     */
    public function __construct(PageRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * @param Page $item
     * @param array $data
     */
    public function handle(PageModelContract $item, array $data)
    {
        $this->dis = $data;

        $this->page = $item;

        $this->getMenu('page', $item->id);

        $happyMethod = '_template_' . studly_case($item->page_template);

        if(method_exists($this, $happyMethod)) {
            return $this->$happyMethod();
        }

        return $this->defaultTemplate();
    }

    /**
     * @return mixed
     */
    protected function defaultTemplate()
    {
        return $this->view('front.page-templates.default');
    }

    /**
     * @return mixed
     */
    protected function _template_Homepage()
    {
        return $this->view('front.page-templates.homepage');
    }
}

<?php namespace DummyNamespace\Http\Controllers\Ecommerce;

use Edutalk\Plugins\Ecommerce\Criterias\Filters\WhereProductPriceBelongsToCurrency;
use Edutalk\Plugins\Ecommerce\Models\Contracts\ProductModelContract;
use Edutalk\Plugins\Ecommerce\Models\Product;
use Edutalk\Plugins\Ecommerce\Repositories\Contracts\ProductCategoryRepositoryContract;
use Edutalk\Plugins\Ecommerce\Repositories\Contracts\ProductLabelRepositoryContract;
use Edutalk\Plugins\Ecommerce\Repositories\Contracts\ProductRepositoryContract;
use Edutalk\Plugins\Ecommerce\Repositories\ProductCategoryRepository;
use Edutalk\Plugins\Ecommerce\Repositories\ProductLabelRepository;
use Edutalk\Plugins\Ecommerce\Repositories\ProductRepository;
use DummyNamespace\Http\Controllers\AbstractController;

class ProductController extends AbstractController
{
    protected $module = 'cosmetics';

    /**
     * @var ProductRepository
     */
    protected $repository;

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var ProductCategoryRepository
     */
    protected $categoryRepository;

    /**
     * @var ProductLabelRepository
     */
    protected $productLabelRepository;

    public function __construct(
        ProductRepositoryContract $repository,
        ProductCategoryRepositoryContract $categoryRepository,
        ProductLabelRepositoryContract $productLabelRepository
    )
    {
        parent::__construct();

        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->productLabelRepository = $productLabelRepository;
    }

    /**
     * @param Product $item
     * @param array $data
     */
    public function handle(ProductModelContract $item, array $data)
    {
        $this->dis = $data;

        $this->product = $item;

        $this->getMenu('product-category', $this->dis['categoryIds']);

        $happyMethod = '_template_' . studly_case($item->page_template);

        if (method_exists($this, $happyMethod)) {
            return $this->$happyMethod();
        }

        return $this->defaultTemplate();
    }

    /**
     * @return mixed
     */
    protected function defaultTemplate()
    {
        $relatedProductIds = $this->repository->getRelatedProductIds($this->product);

        $this->dis['relatedProducts'] = $relatedProductIds
            ? $this->repository
                ->where('products.id', $relatedProductIds)
                ->pushCriteria(new WhereProductPriceBelongsToCurrency(cms_currency()->getApplicationCurrency()->id))
                ->get()
            : [];

        $this->dis['relatedCategories'] = $this->dis['categoryIds']
            ? $this->categoryRepository
                ->where('status', '=', 'activated')
                ->where('id', '=', $this->dis['categoryIds'])
                ->select(['id', 'slug', 'title'])
                ->get()
            : [];

        $this->dis['relatedProductLabels'] = $this->dis['productLabelIds']
            ? $this->productLabelRepository
                ->where('status', '=', 'activated')
                ->where('id', '=', $this->dis['productLabelIds'])
                ->select(['id', 'slug', 'title'])
                ->get()
            : [];

        return $this->view('front.product-templates.default');
    }
}

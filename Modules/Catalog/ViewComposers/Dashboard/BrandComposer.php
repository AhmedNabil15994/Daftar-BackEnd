<?php

namespace Modules\Catalog\ViewComposers\Dashboard;

use Modules\Catalog\Repositories\Dashboard\BrandRepository as Brand;
use Illuminate\View\View;
use Cache;

class BrandComposer
{
    public $brands = [];
    public $sharedActiveBrands = [];

    public function __construct(Brand $category)
    {
        $this->brands = $category->getAll();
        $this->sharedActiveBrands = $category->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with(['brands' => $this->brands, 'sharedActiveBrands' => $this->sharedActiveBrands]);
    }
}

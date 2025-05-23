<?php

namespace Modules\Catalog\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Catalog\Transformers\Api\CategoryResource;
use Modules\Catalog\Repositories\Api\CategoryRepository as Category;

class CategoryController extends ApiController
{
    protected $category;

    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function list(Request $request)
    {
        $categories = $this->category->getAllActive();
        return CategoryResource::collection($categories);
    }
}

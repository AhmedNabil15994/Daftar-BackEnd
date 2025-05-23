<?php

namespace Modules\Catalog\Repositories\Api;

use Modules\Catalog\Entities\Category;

class CategoryRepository
{
    protected $category;

    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAllActive()
    {
        $categories = $this->category->where('category_id', null)->with([
            'children' => function ($query) {
                $query->active();
            },
            'products' => function ($query) {
                $query->active()->limit(12);
                $query->with([
                    'newArrival' => function ($query) {
                        $query->active()->unexpired()->started();
                    },
                    'offer' => function ($query) {
                        $query->active()->unexpired()->started();
                    },
                    'variantChosed' => function ($query) {
                        $query->with(['productValues']);
                    },
                    'images', 'brand', 'categories', 'variants'
                ]);
                $query->whereHas('vendor', function ($query) {
                    $query->active();
                    $query->whereHas('subbscription', function ($q) {
                        $q->active()->unexpired()->started();
                    });
                });
            }
        ])->where('status', true)
            ->orderBy('sorting', 'ASC')
            ->get();

        return $categories;
    }
}

<?php

namespace Modules\Catalog\Repositories\FrontEnd;

use Modules\Catalog\Entities\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    protected $category;

    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $categories = $this->category->with([
            'children' => function ($query) {
                $query->active();
            },
        ])->active()->orderBy($order, $sort)->get();

        return $categories;
    }

    public function getAllNavBar($order = 'id', $sort = 'desc')
    {
        $categories = $this->category->with([
            'children' => function ($query) {
                $query->active();
            },
        ])->where('is_navbar', true)->active()->orderBy($order, $sort)->get();
        return $categories;
    }

    public function mainCategoriesOfVendorProducts($vendor)
    {
        $categories = $this->category->mainCategories()->with([
            'children' => function ($query) {
                $query->active();
            },
        ])
            ->whereHas('products', function ($query) use ($vendor) {
                $query->whereHas('vendor', function ($query) use ($vendor) {
                    $query->where('vendor_id', $vendor->id);
                    $query->active();
                    $query->whereHas('subbscription', function ($q) {
                        $q->active()->unexpired()->started();
                    });
                });
            })
            ->active()
            ->orderBy('sorting', 'DESC')
            ->get();

        return $categories;
    }

    public function mainCategories()
    {
        $categories = $this->category->mainCategories()->with([
            'children' => function ($query) {
                $query->active();
            },
        ])
            ->active()
            ->orderBy('sorting', 'ASC')
            ->get();

        return $categories;
    }

    public function findBySlug($slug, $vendorSlug)
    {
        $category = $this->category->active()->with([
            'children' => function ($query) {
                $query->active();
            },
        ])->whereHas('products', function ($query) use ($vendorSlug) {
            $query->whereHas('vendor', function ($query) use ($vendorSlug) {
                $query->whereTranslation('slug', $vendorSlug);
                $query->active();
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            });
        })->whereTranslation('slug', $slug)->first();

        return $category;
    }

    public function findById($id)
    {
        return $this->category->active()->with([
            'children' => function ($query) {
                $query->active();
            },
        ])->find($id);
    }

    public function findBySlugWithoutVendor($slug)
    {
        $category = $this->category->active()->with([
            'children' => function ($query) {
                $query->active();
            },
        ])->whereTranslation('slug', $slug)->first();

        return $category;
    }

    public function checkRouteLocale($model, $slug)
    {
        if ($model && $model->translate()->where('slug', $slug)->first()->locale != locale())
            return false;

        return true;
    }
}

<?php

namespace Modules\Catalog\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Vendor\Repositories\FrontEnd\VendorRepository as Vendor;
use Modules\Catalog\Repositories\FrontEnd\BrandRepository as Brand;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Modules\Catalog\Repositories\FrontEnd\CategoryRepository as Category;

class FilterController extends Controller
{

    function __construct(Vendor $vendor, Product $product, Category $category, Brand $brand)
    {
        $this->product = $product;
        $this->vendor = $vendor;
        $this->category = $category;
        $this->brand = $brand;
    }

    public function index(Request $request, $slug)
    {
        $vendor = $this->vendor->findByslug($slug);

        if (!$vendor)
            abort(404);


        $sorting = $request['sorting'] ? $request['sorting'] : 'id';
        $productsList = $this->product->filterProducts($request, $slug, $sorting);
        $categories = $this->category->mainCategoriesOfVendorProducts($vendor);
        $brands = $this->brand->getAllActiveByVendor($vendor);
        $rangePrice = $this->product->rangePrice($vendor);

        if ($this->vendor->checkRouteLocale($vendor, $slug)) {
            return view('vendor::frontend.vendors.index',
                compact('vendor', 'productsList', 'categories', 'brands', 'rangePrice')
            );
        }

        return view('catalog::frontend.filters.index', compact('vendor', 'productsList'));
    }


    public function categoriesFilter(Request $request, $vendorSlug, $categorySlug)
    {
        $vendor = $this->vendor->findByslug($vendorSlug);
        $category = $this->category->findBySlug($categorySlug, $vendorSlug);

        if (!$vendor)
            abort(404);

        if (!$category)
            abort(404);

        $sorting = $request['sorting'] ? $request['sorting'] : 'id';
        $productsList = $this->product->filterProductsOfCategory($request, $vendorSlug, $category, $sorting);

        $categories = $this->category->mainCategoriesOfVendorProducts($vendor);
        $brands = $this->brand->getAllActiveByVendor($vendor);
        $rangePrice = $this->product->rangePrice($vendor);

        if ($this->category->checkRouteLocale($category, $categorySlug)) {
            return view('catalog::frontend.categories.index',
                compact('vendor', 'productsList', 'categories', 'brands', 'rangePrice', 'category')
            );
        }

        return redirect()->route('frontend.categories.index', [
            $vendor->translate(locale())->slug,
            $category->translate(locale())->slug
        ]);
    }


    public function filterWithCategory(Request $request, $categorySlug = null)
    {
        $category = $this->category->findBySlugWithoutVendor($categorySlug);

        /*if (!$category)
            abort(404);*/

        $sorting = $request['sorting'] ?? 'id';
        $productsList = $this->product->productsOfCategory($request, $category, $sorting);
        $categories = $this->category->mainCategories();
        $brands = $this->brand->getAllActiveByCategory($category);
        $rangePrice = $this->product->rangePriceByCategory($category);

        if ($this->category->checkRouteLocale($category, $categorySlug)) {
            return view('catalog::frontend.categories.show',
                compact('productsList', 'categories', 'brands', 'rangePrice', 'category')
            );
        }

        return redirect()->route('frontend.categories.show', [
            $category ? $category->translate(locale())->slug : null
        ]);
    }
}

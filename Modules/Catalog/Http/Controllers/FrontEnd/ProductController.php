<?php

namespace Modules\Catalog\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;

class ProductController extends Controller
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index($vendorSlug, $slug)
    {
        $product = $this->product->findBySlug($vendorSlug, $slug);
        if (!$product) {
            abort(404);
        }

        $related = $this->product->relatedProuctsOfVendor(
            $vendorSlug,
            $product->categories ? $product->categories->pluck('id') : []
        );

        $options = count($product->variants) > 0 ? $this->product->getVariantsOfProduct($product) : [];

        if ($this->product->checkRouteLocale($product, $slug)) {
            return view('catalog::frontend.products.index', compact('product', 'related', 'options'));
        }

        return redirect()->route('frontend.products.index', [
            $product->vendor->translate(locale())->slug,
            $product->translate(locale())->slug
        ]);
    }

    public function variations(Request $request)
    {
        $product = $this->product->productWithVariations($request);

        if (!$product) {
            return \Response::json(["errors" => $product], 422);
        }

        return \Response::json($product, 200);
    }
}

<?php

namespace Modules\Catalog\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Catalog\Transformers\Api\CartProductQtyResource;
use Modules\Catalog\Transformers\Api\CartVariationQtyResource;
use Modules\Catalog\Transformers\Api\ProductResource;
use Modules\Catalog\Transformers\Api\ProductVariationResource;
use Modules\Catalog\Repositories\Api\ProductRepository as ProductRepo;

class ProductController extends ApiController
{
    protected $product;

    function __construct(ProductRepo $product)
    {
        $this->product = $product;
    }

    public function show($id)
    {
        $product = $this->product->findById($id);
        if ($product) {
            $relatedProducts = $this->product->getRelatedProducts($product->categories ? $product->categories->pluck('id')->toArray() : []);
            $result = [
                'product' => new ProductResource($product),
                'related_products' => ProductResource::collection($relatedProducts),
            ];
            return $this->response($result);
        } else
            return $this->response(null);
    }

    public function list(Request $request)
    {
        $products = $this->product->getAllActive($request);
        return ProductResource::collection($products);
    }

    public function offers(Request $request)
    {
        $products = $this->product->getAllOffers($request);
        return ProductResource::collection($products);
    }

    public function newArrival(Request $request)
    {
        $products = $this->product->getAllNewArrival($request);
        return ProductResource::collection($products);
    }

    public function mostPopular(Request $request)
    {
        $products = $this->product->getAllPopular($request);
        return ProductResource::collection($products);
    }

    public function variation(Request $request)
    {
        $variant = $this->product->getVariationOfProduct($request);

        if ($variant) {
            return $this->response(new ProductVariationResource($variant));
        }

        return $this->error([]);
    }

    public function getCartProductsQty(Request $request)
    {
        $productsIDs = [];
        $variationsIDs = [];
        $ids = array_values($request->product_id ?? []);
        $types = array_values($request->product_type ?? []);

        if (!empty($types)) {
            foreach ($types as $k => $type) {
                if ($type == 'product')
                    $productsIDs[] = $ids[$k];
                else
                    $variationsIDs[] = $ids[$k];
            }
        }
        $products = $this->product->getCartProductsQty($productsIDs, $variationsIDs)['products'];
        $variations = $this->product->getCartProductsQty($productsIDs, $variationsIDs)['variations'];

        $productsResource = CartProductQtyResource::collection($products)->toArray(request());
        $variationsResource = collect(CartVariationQtyResource::collection($variations))->toArray();
        $response = array_merge($productsResource, $variationsResource);
        return $this->response($response);
    }
}

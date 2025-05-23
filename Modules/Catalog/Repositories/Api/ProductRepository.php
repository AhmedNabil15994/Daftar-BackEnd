<?php

namespace Modules\Catalog\Repositories\Api;

use Modules\Catalog\Traits\CatalogTrait;
use Modules\Variation\Entities\ProductVariantValue;
use Modules\Variation\Entities\ProductVariant;
use Modules\Variation\Entities\Option;
use Modules\Catalog\Entities\Product;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepository
{
    use CatalogTrait;

    protected $product;
    protected $option;
    protected $variant;

    function __construct(Product $product, Option $option, ProductVariant $variant)
    {
        $this->product = $product;
        $this->option = $option;
        $this->variant = $variant;
    }

    public function getAllActive($request)
    {
        $allCats = $this->getAllSubCategoryIds($request->category_id);
        array_push($allCats, intval($request->category_id));

        $sorting = $this->sorting($request->sorting ?? 'id');

        $products = $this->product->where('status', true)->with([
            'newArrival' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'offer' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'images', 'brand', 'categories', 'variants'
        ]);

        $products = $products->whereHas('vendor', function ($query) {
            $query->active();
            $query->whereHas('subbscription', function ($q) {
                $q->active()->unexpired()->started();
            });
        });

        if ($request['category_id']) {
            $products->whereHas('categories', function ($query) use ($allCats) {
                $query->whereIn('product_categories.category_id', $allCats);
            });
        }

        if ($request['brand_id']) {
            $products->whereIn('brand_id', $request['brand_id']);
        }

        //Add vendor ID to the filter keys
        if ($request['vendor_id']) {
            $products->where('vendor_id', $request['vendor_id']);
        }

        if ($request['search_key']) {
            $products->whereHas('translations', function ($query) use ($request) {

                $query->where('description', 'like', '%' . $request['search_key'] . '%');
                $query->orWhere('title', 'like', '%' . $request['search_key'] . '%');
                $query->orWhere('slug', 'like', '%' . $request['search_key'] . '%');
            });
        }

        if ($request['low_price'] && $request['high_price']) {
            $products->whereBetween('price', [$request['low_price'], $request['high_price']]);
        }

        return $products->orderBy($sorting['sort'], $sorting['order'])->distinct()->paginate(24);
    }

    public function getAllOffers($request)
    {
        /* $products = QueryBuilder::for(Product::class)
            ->defaultSort('-sort')
            ->allowedSorts('sort');

        $products = $products->with([
            'newArrival' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'offer' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'images', 'brand', 'categories', 'variants'
        ]); */

        $products = $this->product->with([
            'newArrival' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'offer' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'images', 'brand', 'categories', 'variants'
        ]);

        $products = $products->where('status', true)
            ->whereHas('offer', function ($query) {
                $query->active()->unexpired()->started();
            });

        $products = $products->whereHas('vendor', function ($query) {
            $query->active();
            $query->whereHas('subbscription', function ($q) {
                $q->active()->unexpired()->started();
            });
        });

        if ($request['category_id']) {
            $products->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('categories.id', $request['category_id']);
            });
        }

        if ($request['brand_id']) {
            $products->whereIn('brand_id', $request['brand_id']);
        }

        return $products->orderBy('sort', 'desc')->distinct()->paginate(24);
    }

    public function getAllNewArrival($request)
    {
        $products = $this->product->where('status', true)
            ->whereHas('newArrival', function ($query) {
                $query->active()->unexpired()->started();
            })
            ->with([
                'newArrival' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'images', 'brand', 'categories', 'variants'
            ]);

        $products = $products->whereHas('vendor', function ($query) {
            $query->active();
            $query->whereHas('subbscription', function ($q) {
                $q->active()->unexpired()->started();
            });
        });

        if ($request['category_id']) {
            $products->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('categories.id', $request['category_id']);
            });
        }

        if ($request['brand_id']) {
            $products->whereIn('brand_id', $request['brand_id']);
        }

        return $products->orderBy('sort', 'DESC')->distinct()->paginate(24);
    }

    public function getAllPopular($request)
    {
        $products = $this->product->with([
            'newArrival' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'offer' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'images', 'brand', 'categories', 'variants'
        ])->where('status', true)
            ->where('most_popular', true);

        $products = $products->whereHas('vendor', function ($query) {
            $query->active();
            $query->whereHas('subbscription', function ($q) {
                $q->active()->unexpired()->started();
            });
        });

        if ($request['category_id']) {
            $products->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('categories.id', $request['category_id']);
            });
        }

        if ($request['brand_id']) {
            $products->whereIn('brand_id', $request['brand_id']);
        }

        return $products->orderBy('sort', 'DESC')->distinct()->paginate(24);
    }

    public function getVariationOfProduct($request)
    {
        $variants = $this->variant->with('productValues')->where('product_id', $request['product_id'])->get();

        foreach ($variants as $variant) {

            foreach ($variant->productValues->groupBy('product_variant_id') as $key => $value) {

                $optionValues = Arr::pluck($value, 'option_value_id');

                if ($request['values'] == $optionValues)
                    $variantId = $key;
            }
        }

        if (isset($variantId)) {
            return $this->variant->find($variantId);
        }

        return false;
    }

    public function findById($id, $variantId = null)
    {
        return $this->product->where('status', 1)
            ->where('id', $id)->with([
                'newArrival' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'variantChosed' => function ($query) use ($variantId) {
                    $query->where('id', $variantId)->with(['productValues']);
                },
                'images', 'brand', 'categories', 'variants'
            ])
            ->whereHas('vendor', function ($query) {
                $query->active();
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            })
            ->first();
    }

    public function getRelatedProducts($categoriesIds = [])
    {
        return $this->product->where('status', true)
            ->whereHas('categories', function ($query) use ($categoriesIds) {
                $query->whereIn('categories.id', $categoriesIds);
            })
            ->whereHas('vendor', function ($query) {
                $query->active();
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            })
            ->with([
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
            ])->inRandomOrder()->take(12)->get();
    }

    public function getCartProductsQty($productsIDs, $variationsIDs)
    {
        $productsResult = $this->product->where('status', true)
            ->whereIn('id', $productsIDs)
            ->whereHas('vendor', function ($query) {
                $query->active();
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            })->get(['id', 'qty']);

        $variationsResult = $this->variant->where('status', true)
            ->whereIn('id', $variationsIDs)
            ->whereHas('product.vendor', function ($query) {
                $query->active();
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            })->get(['id', 'qty']);

        return [
            'products' => $productsResult,
            'variations' => $variationsResult,
        ];
    }

    protected function sorting($sortBy)
    {
        switch ($sortBy) {

            case 'new_arrival':

                return [
                    'sort' => 'id',
                    'order' => 'DESC'
                ];
                break;

            case 'most_selling':

                return [
                    'sort' => 'selling',
                    'order' => 'DESC'
                ];
                break;

            case 'low_price':

                return [
                    'sort' => 'price',
                    'order' => 'ASC'
                ];
                break;

            default:
                return [
                    'sort' => 'sort',
                    'order' => 'DESC'
                ];
                break;
        }
    }
}

<?php

namespace Modules\Catalog\Repositories\FrontEnd;

use Modules\Variation\Entities\ProductVariantValue;
use Modules\Variation\Entities\ProductVariant;
use Modules\Variation\Entities\Option;
use Modules\Catalog\Entities\Product;
use Illuminate\Support\Arr;
use DB;

class ProductRepository
{

    function __construct(Product $product, Option $option, ProductVariant $variant)
    {
        $this->product = $product;
        $this->option = $option;
        $this->variant = $variant;
    }

    public function searchProducts($text)
    {
        $products = $this->product->active()
            ->with([
                'newArrival' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
            ])
            ->whereHas('translations', function ($query) use ($text) {

                $query->where('description', 'like', '%' . $text . '%');
                $query->orWhere('title', 'like', '%' . $text . '%');
                $query->orWhere('slug', 'like', '%' . $text . '%');
            })->whereHas('vendor', function ($query) {
                $query->active();
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            })->get()->groupBy('vendor_id');

        return $products;
    }

    public function filterProducts($request, $vendorSlug, $sort = 'id')
    {
        $sorting = $this->sorting($sort);

        $products = $this->product->active()
            ->with([
                'newArrival' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
            ])
            ->whereHas('vendor', function ($query) use ($vendorSlug) {
                $query->active();
                $query->whereTranslation('slug', $vendorSlug);
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            });


        if ($request['categories']) {
            $products->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('categories.id', $request['categories']);
            });
        }

        if ($request['brands']) {
            $products->whereIn('brand_id', $request['brands']);
        }

        if ($request['low_price'] && $request['high_price']) {
            $products->whereBetween('price', [$request['low_price'], $request['high_price']]);
        }

        return $products->orderBy($sorting['sort'], $sorting['order'])->paginate(24);
    }

    public function filterProductsOfCategory($request, $vendorSlug, $category, $sort = 'id')
    {
        $sorting = $this->sorting($sort);

        $products = $this->product->active()
            ->with([
                'newArrival' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
            ])
            ->whereHas('vendor', function ($query) use ($vendorSlug) {
                $query->active();
                $query->whereTranslation('slug', $vendorSlug);
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            })->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category->id);
            });


        if ($request['categories_filter']) {
            $products->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('categories.id', $request['categories_filter']);
            });
        }

        if ($request['brands']) {
            $products->whereIn('brand_id', $request['brands']);
        }

        if ($request['low_price'] && $request['high_price']) {
            $products->whereBetween('price', [$request['low_price'], $request['high_price']]);
        }

        return $products->orderBy($sorting['sort'], $sorting['order'])->paginate(24);
    }

    public function productsOfCategory($request, $category, $sort = 'id')
    {
        $sorting = $this->sorting($sort);

        $products = $this->product->active()
            ->with([
                'newArrival' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
            ]);

        if (!is_null($category)) {
            $products = $products->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category->id);
            });
        }

        $products = $products->whereHas('vendor', function ($query) {
            $query->active();
            $query->whereHas('subbscription', function ($q) {
                $q->active()->unexpired()->started();
            });
        });

        if ($request['categories_filter']) {
            $products->whereHas('categories', function ($query) use ($request) {
                $query->whereIn('categories.id', $request['categories_filter']);
            });
        }

        if ($request['brands']) {
            $products->whereIn('brand_id', $request['brands']);
        }

        if ($request['low_price'] && $request['high_price']) {
            $products->whereBetween('price', [$request['low_price'], $request['high_price']]);
        }

        return $products->orderBy($sorting['sort'], $sorting['order'])->paginate(24);
    }

    public function getAllActive($order = 'sort', $sort = 'desc')
    {
        $products = $this->product->active()
            ->with([
                'newArrival' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
            ])
            ->whereHas('vendor', function ($query) {
                $query->active();
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            })
            // ->orderBy($order, $sort)->orderBy('qty', 'DESC')
            ->orderBy($order, $sort)
            ->get();

        return $products;
    }

    public function rangePrice($vendor)
    {
        $products['low'] = $this->product->active()
            ->with([
                'newArrival' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
            ])
            ->whereHas('vendor', function ($query) use ($vendor) {
                $query->active();
                $query->where('vendor_id', $vendor->id);
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
                $query->whereHas('sections', function ($q) {
                    $q->active();
                });
            })->min('price');

        $products['high'] = $this->product->active()
            ->whereHas('vendor', function ($query) use ($vendor) {
                $query->where('vendor_id', $vendor->id);
            })->max('price');

        return $products;
    }

    public function rangePriceByCategory($category)
    {
        $lowProducts = $this->product->active()->with([
            'newArrival' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'offer' => function ($query) {
                $query->active()->unexpired()->started();
            },
        ]);

        if (!is_null($category)) {
            $lowProducts = $lowProducts->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category['id']);
            });
        }
        $products['low'] = $lowProducts->min('price');

        $highProducts = $this->product->active()->with([
            'newArrival' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'offer' => function ($query) {
                $query->active()->unexpired()->started();
            },
        ]);
        if (!is_null($category)) {
            $highProducts = $highProducts->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category['id']);
            });
        }
        $products['high'] = $highProducts->max('price');

        return $products;
    }

    public function prouctsOfCategoriesPaginate($vendor, $category, $sort = 'id')
    {
        $sorting = $this->sorting($sort);

        $products = $this->product
            ->with([
                'newArrival' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'images',
            ])->whereHas('vendor', function ($query) use ($vendor) {
                $query->active();
                $query->where('vendor_id', $vendor->id);
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            })->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category->id);
            })
            ->active()
            ->orderBy($sorting['sort'], $sorting['order'])
            ->paginate(24);

        return $products;
    }

    public function prouctsOfVendorPaginate($vendor, $sort = 'id')
    {
        $sorting = $this->sorting($sort);

        $products = $this->product
            ->with([
                'newArrival' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                }
            ])->whereHas('vendor', function ($query) use ($vendor) {
                $query->active();
                $query->where('vendor_id', $vendor->id);
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            })
            ->active()
            ->orderBy($sorting['sort'], $sorting['order'])
            ->paginate(24);

        return $products;
    }


    public function prouctsOfVendorSlugPaginate($vendorSlug)
    {
        $products = $this->product
            ->with([
                'newArrival' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'images',
            ])->whereHas('vendor', function ($query) use ($vendorSlug) {
                $query->active();
                $query->whereTranslation('slug', $vendorSlug);
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            })
            ->active()
            // ->orderBy('qty', 'DESC')
            ->orderBy('sort', 'DESC')
            ->paginate(24);

        return $products;
    }

    public function relatedProuctsOfVendor($vendorSlug, $categoriesIds)
    {
        $products = $this->product
            ->whereHas('categories', function ($query) use ($categoriesIds) {
                $query->whereIn('categories.id', $categoriesIds);
            })
            ->whereHas('vendor', function ($query) use ($vendorSlug) {
                $query->active();
                $query->whereTranslation('slug', $vendorSlug);
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
            ])->active()->inRandomOrder()->take(12)->get();

        return $products;
    }

    public function findBySlug($vendorSlug, $slug)
    {
        $product = $this->product->active()
            ->whereHas('vendor', function ($query) use ($vendorSlug) {
                $query->active();
                $query->whereTranslation('slug', $vendorSlug);
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
                'images',
            ])->whereTranslation('slug', $slug)->first();

        return $product;
    }

    public function findById($id)
    {
        return $this->product->active()
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
                'vendor' => function ($query) {
                    $query->active();
                    $query->whereHas('subbscription', function ($q) {
                        $q->active()->unexpired()->started();
                    });
                },
                'images',
            ])->find($id);
    }

    public function findBySlugWithoutVendorSlug($slug, $request = null)
    {
        $product = $this->product->active()
            ->where('deleted_at', null)
            ->with([
                'images',
                'newArrival' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'offer' => function ($query) {
                    $query->active()->unexpired()->started();
                },
                'vendor' => function ($query) {
                    $query->whereHas('subbscription', function ($q) {
                        $q->active()->unexpired()->started();
                    });
                },
                'variantChosed' => function ($query) use ($request) {
                    $query->where('id', $request['variant_id'])->with(['productValues']);
                },
            ])->whereHas('vendor', function ($query) {
                $query->active();
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            })->whereTranslation('slug', $slug)->first();

        return $product;
    }

    public function checkRouteLocale($model, $slug)
    {
        if ($model->translate()->where('slug', $slug)->first()->locale != locale())
            return false;

        return true;
    }


    public function getVariantsOfProduct($product)
    {
        $options = [];

        foreach ($product->variantValues->unique('option_value_id') as $key => $value) {
            $options[$value->optionValue->option_id][] = $value;
        }

        return $this->getOption($options);
    }

    public function getOption($options)
    {

        foreach ($options as $key => $value) {
            $id[$key] = [
                'option' => $this->option->find($key),
                'values' => $value
            ];
        }

        return $id;
    }

    public function productWithVariations($request)
    {
        $variantId = 0;
        $variants = $this->variant->with('productValues')->where('product_id', $request['product_id'])->get();

        foreach ($variants as $variant) {

            foreach ($variant->productValues->groupBy('product_variant_id') as $key => $value) {

                $optionValues = Arr::pluck($value, 'option_value_id');

                if ($request['values'] == $optionValues)
                    $variantId = $key;
            }
        }

        return $this->variant->find($variantId);
    }

    public function sorting($sortBy)
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

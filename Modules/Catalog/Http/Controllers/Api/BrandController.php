<?php

namespace Modules\Catalog\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Catalog\Transformers\Api\BrandResource;
use Modules\Catalog\Repositories\Api\BrandRepository as Brand;

class BrandController extends ApiController
{
    function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function list(Request $request)
    {
        $brands =  $this->brand->getAllActive();
        return BrandResource::collection($brands);
    }
}

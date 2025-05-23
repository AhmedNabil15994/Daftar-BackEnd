<?php

namespace Modules\Catalog\Repositories\Api;

use Modules\Catalog\Entities\Brand;

class BrandRepository
{
    function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function getAllActive()
    {
        $categories = $this->brand->where('status',true)->get();

        return $categories;
    }
}

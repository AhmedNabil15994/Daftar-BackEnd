<?php

namespace Modules\Area\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Area\Transformers\Api\CityResource;
use Modules\Area\Repositories\Api\CityRepository as City;
use Modules\Apps\Http\Controllers\Api\ApiController;

class AreaController extends ApiController
{

    function __construct(City $city)
    {
        $this->city = $city;
    }


    public function cities()
    {
        $cities = $this->city->getAllActive();

        return $this->response(CityResource::collection($cities));
    }
}

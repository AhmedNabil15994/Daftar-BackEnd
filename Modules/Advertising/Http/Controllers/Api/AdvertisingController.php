<?php

namespace Modules\Advertising\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Advertising\Transformers\Api\AdvertisingGroupResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Advertising\Transformers\Api\AdvertisingResource;
use Modules\Advertising\Repositories\Api\AdvertisingRepository as Advertising;

class AdvertisingController extends ApiController
{
    protected $advertising;

    function __construct(Advertising $advertising)
    {
        $this->advertising = $advertising;
    }

    public function list(Request $request)
    {
        $ads = $this->advertising->getAllActive($request);
        return $this->response(AdvertisingResource::collection($ads));
    }

    public function getAdvertGroups(Request $request)
    {
        $adverts = $this->advertising->getAdvertGroups($request);
        return $this->response(AdvertisingGroupResource::collection($adverts));
    }

    public function getRandomAdvert(Request $request)
    {
        $advert = $this->advertising->getRandomAdvert($request);
        if ($advert)
            return $this->response(new AdvertisingResource($advert));
        else
            return $this->response(null);
    }
}

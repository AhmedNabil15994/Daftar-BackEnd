<?php

namespace Modules\Slider\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Slider\Transformers\Api\SliderResource;
use Modules\Slider\Repositories\Api\SliderRepository as Slider;

class SliderController extends ApiController
{
    protected $slider;

    function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function list(Request $request)
    {
        $sliders = $this->slider->getAllActive();
        return SliderResource::collection($sliders);
    }
}

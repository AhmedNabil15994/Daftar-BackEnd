<?php

namespace Modules\Slider\Repositories\FrontEnd;

use Modules\Slider\Entities\Slider;

class SliderRepository
{

    function __construct(Slider $slider)
    {
        $this->slider   = $slider;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        return $this->slider->whereNull('deleted_at')->active()->inRandomOrder()->take(4)->get();
    }

}

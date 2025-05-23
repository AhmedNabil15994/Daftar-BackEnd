<?php

namespace Modules\Slider\Repositories\Api;

use Modules\Slider\Entities\Slider;

class SliderRepository
{
    protected $slider;

    function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function getAllActive()
    {
        return $this->slider->where('status', true)->sortAsc()->get();
    }
}

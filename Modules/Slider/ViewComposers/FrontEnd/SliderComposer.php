<?php

namespace Modules\Slider\ViewComposers\FrontEnd;

use Modules\Slider\Repositories\FrontEnd\SliderRepository as Slider;
use Illuminate\View\View;
use Cache;

class SliderComposer
{
    public $sliders = [];

    public function __construct(Slider $sliders)
    {
        $this->sliders =  $sliders->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('sliders' , $this->sliders);
    }
}

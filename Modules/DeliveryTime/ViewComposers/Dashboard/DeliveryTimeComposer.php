<?php

namespace Modules\DeliveryTime\ViewComposers\Dashboard;

use Modules\DeliveryTime\Repositories\Dashboard\DeliveryTimeRepository as DeliveryTime;
use Illuminate\View\View;
use Cache;

class DeliveryTimeComposer
{
    public $times = [];

    public function __construct(DeliveryTime $time)
    {
        $this->times =  $time->getAllActive();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('times' , $this->times);
    }
}

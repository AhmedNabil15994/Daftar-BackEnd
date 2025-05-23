<?php

namespace Modules\User\ViewComposers\Vendor;

use Illuminate\View\View;
use Modules\User\Repositories\Vendor\DriverRepository as Driver;

class DriverComposer
{
    public $drivers = [];

    public function __construct(Driver $driver)
    {
        $this->drivers = $driver->getAllDrivers();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('drivers', $this->drivers);
    }
}

<?php

namespace Modules\DeliveryTime\ViewComposers\Dashboard;

use Modules\DeliveryTime\Repositories\Dashboard\DeliveryStatusRepository as DeliveryStatus;
use Illuminate\View\View;

class DeliveryStatusComposer
{
    public $statuses = [];

    public function __construct(DeliveryStatus $status)
    {
        $this->statuses = $status->getAll();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('deliveryStatuses', $this->statuses);
    }
}

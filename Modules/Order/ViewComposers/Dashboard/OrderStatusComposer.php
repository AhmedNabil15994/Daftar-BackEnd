<?php

namespace Modules\Order\ViewComposers\Dashboard;

use Modules\Order\Repositories\Dashboard\OrderStatusRepository as OrderStatus;
use Illuminate\View\View;

class OrderStatusComposer
{
    protected $orderStatus;

    public function __construct(OrderStatus $orderStatus)
    {
        $this->orderStatus = $orderStatus->getAll();
    }

    public function compose(View $view)
    {
        $view->with('orderStatuses', $this->orderStatus);
    }
}

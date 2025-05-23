<?php

namespace Modules\Order\ViewComposers\Vendor;

use Modules\Order\Repositories\Vendor\OrderStatusRepository as OrderStatus;
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

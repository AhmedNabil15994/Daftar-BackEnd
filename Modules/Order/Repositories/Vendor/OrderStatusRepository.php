<?php

namespace Modules\Order\Repositories\Vendor;

use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\OrderStatus;

class OrderStatusRepository
{
    protected $orderStatus;

    public function __construct(OrderStatus $orderStatus)
    {
        $this->orderStatus = $orderStatus;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $orderStatuses = $this->orderStatus->orderBy($order, $sort)->get();
        return $orderStatuses;
    }

    public function getAllFinalStatus($order = 'id', $sort = 'desc')
    {
        $orderStatuses = $this->orderStatus->finalStatus()->orderBy($order, $sort)->get();
        return $orderStatuses;
    }

    public function findById($id)
    {
        $orderStatus = $this->orderStatus->find($id);
        return $orderStatus;
    }

}

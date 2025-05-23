<?php

namespace Modules\DeliveryTime\Repositories\Dashboard;

use Modules\DeliveryTime\Entities\DeliveryStatus;
use Illuminate\Support\Facades\DB;

class DeliveryStatusRepository
{
    protected $status;

    function __construct(DeliveryStatus $status)
    {
        $this->status   = $status;
    }

    public function getAll($order = 'id', $sort = 'asc')
    {
        return $this->status->orderBy($order, $sort)->get();
    }
}

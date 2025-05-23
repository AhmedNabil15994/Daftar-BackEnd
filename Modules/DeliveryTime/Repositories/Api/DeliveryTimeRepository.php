<?php

namespace Modules\DeliveryTime\Repositories\Api;

use Modules\DeliveryTime\Entities\DeliveryTime;
use Modules\DeliveryTime\Entities\CustomDeliveryTime;
use Hash;
use Illuminate\Support\Facades\DB;

class DeliveryTimeRepository
{
    protected $time;
    protected $customTime;

    function __construct(DeliveryTime $time, CustomDeliveryTime $customTime)
    {
        $this->time   = $time;
        $this->customTime   = $customTime;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $times = $this->time->active()->orderBy($order, $sort)->get();
        return $times;
    }

    public function getActiveTimes($date)
    {
        $times = $this->time->active()->orderBy('id', 'DESC');

        if (date('Y-m-d') == $date) {
            $times->where('last_order', '>', date('H:s:i'))->where('to', '>', date('H:s:i'));
        }

        return $times->get();
    }

    public function getActiveCustomTimes()
    {
        $times = $this->customTime->active();
        return $times->get();
    }

    public function getActiveCustomTimeByDay($dayCode)
    {
        return $this->customTime->active()->where('day_code', $dayCode)->first();
    }
}

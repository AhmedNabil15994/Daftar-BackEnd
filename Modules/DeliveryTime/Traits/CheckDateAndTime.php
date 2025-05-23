<?php

namespace Modules\DeliveryTime\Traits;

use Carbon\Carbon;
use Modules\DeliveryTime\Entities\DeliveryTime;
use Illuminate\Support\MessageBag;

trait CheckDateAndTime
{
    public function checkTimeSlot($request)
    {
        $selectedTime = DeliveryTime::find($request['time']);

        if (
            (date('H:s:i') > $selectedTime['last_order'] || date('H:s:i') > $selectedTime['to'])
            &&
            ($request['date'] == date('Y-m-d'))
        ) {
            return __('catalog::frontend.products.alerts.time_date_not_accepted');
        }
    }

    private function checkIfTimeAvailable($timeFrom, $timeTo, $customTimes = [])
    {
        if (!empty($customTimes)) {
            $check = collect($customTimes)->where('time_from', $timeFrom)->where('time_to', $timeTo)->first();
            if (is_null($check))
                return false;
            else
                return true;
        } else {
            return false;
        }
    }
}

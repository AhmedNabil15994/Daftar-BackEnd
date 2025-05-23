<?php

namespace Modules\DeliveryTime\Http\Controllers\Api;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\DeliveryTime\Transformers\Api\DeliveryTimeResource;
use Modules\DeliveryTime\Repositories\Api\DeliveryTimeRepository as DeliveryTime;
use Illuminate\Support\Str;

class DeliveryTimeController extends ApiController
{
    protected $deliveryTime;

    function __construct(DeliveryTime $deliveryTime)
    {
        $this->deliveryTime = $deliveryTime;
    }

    public function list()
    {
        $deliveryTimes = $this->deliveryTime->getAllActive();
        return DeliveryTimeResource::collection($deliveryTimes);
    }

    public function getWeeklyDeliveryTimes(Request $request)
    {
        $deliveryTimes = $this->deliveryTime->getActiveCustomTimes();
        $buildDays = [];
        if ($deliveryTimes) {
            $startDate = Carbon::today()->format('Y-m-d');
            $endDate = Carbon::today()->addDays(6)->format('Y-m-d');
            $period = CarbonPeriod::create($startDate, $endDate);

            foreach ($period as $index => $date) {
                $shortDay = Str::lower($date->format('D'));
                $deliveryTimesDays = array_column($deliveryTimes->toArray() ?? [], 'day_code');
                if (in_array($shortDay, $deliveryTimesDays)) {
                    $customDeliveryTime = $deliveryTimes->where('day_code', $shortDay)->first();
                    $customTime = [
                        'date' => $date->format('Y-m-d'),
                        'day_code' => $shortDay,
                        'day_name' => __('apps::dashboard.availabilities.days.' . $shortDay),
                        'status' => true,
                    ];
                    if ($customDeliveryTime->is_full_day == 1) {
                        $customTime['times'] = [
                            ["time_from" => "12:00 AM", "time_to" => "11:00 PM"]
                        ];
                        $buildDays[] = $customTime;
                    } else {
                        if ($date->format('Y-m-d') == date('Y-m-d')) {
                            $customTime['times'] = collect($customDeliveryTime->custom_times)->map(function ($item) {
                                return $item;
                            })->reject(function ($item) {
                                return strtotime($item['time_from']) < strtotime(date('g:i A'));
                            })->values();
                        } else {
                            $customTime['times'] = $customDeliveryTime->custom_times;
                        }

                        if (count($customTime['times']) > 0) { // remove the day if times are empty
                            $buildDays[] = $customTime;
                        }
                    }
                } else {
                    $customTime = [
                        'date' => $date->format('Y-m-d'),
                        'day_code' => $shortDay,
                        'day_name' => __('apps::dashboard.availabilities.days.' . $shortDay),
                        'status' => false,
                        'times' => [],
                    ];
                    $buildDays[] = $customTime;
                }
            }

            return $this->response($buildDays);
        } else {
            return $this->response(null);
        }
    }
}

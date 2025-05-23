<?php

namespace Modules\Catalog\Http\Controllers\FrontEnd;

use Carbon\Carbon;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Catalog\Http\Requests\FrontEnd\CheckoutLimitationRequest;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Modules\Vendor\Entities\Vendor;
use Modules\DeliveryTime\Repositories\Api\DeliveryTimeRepository as Times;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    use ShoppingCartTrait;

    protected $product;
    protected $times;

    function __construct(Product $product, Times $times)
    {
        $this->product = $product;
        $this->times = $times;
    }

    public function index(Request $request)
    {
        $address = Cart::getCondition('delivery_fees')->getAttributes()['address'];
        $items = Cart::getContent();
        $vendor = Vendor::find($items->first()->attributes->product->vendor->id);

        /* $times = $this->times->getActiveTimes(date('Y-m-d'));
        $selectedTime = $this->getNearestTime($times->pluck('to')->toArray()); */

        $activeCustomTimeDays = $this->times->getActiveCustomTimes()->pluck('day_code')->toArray() ?? [];
        $customTime = $this->getCustomDeliveryTimes(date('Y-m-d'), 'checkout');
        $times = $customTime['times'];
        $selectedTime = $customTime['selectedTime'];
        $calendarDay = $customTime['calendarDay'];

        return view('catalog::frontend.checkout.index', compact('address', 'vendor', 'times', 'selectedTime', 'activeCustomTimeDays', 'calendarDay'));
    }

    public function times(Request $request)
    {
        $times = $this->times->getActiveTimes($request['selected_date']);
        $selectedTime = $this->getNearestTime($times->pluck('to')->toArray());
        return view('catalog::frontend.checkout.html.times', compact('times', 'selectedTime'));
    }

    public function getCustomDeliveryTimes($selected_date, $flag = 'selected_day')
    {
        $carbonDay = Carbon::createFromFormat('Y-m-d', $selected_date);
        $dayCode =  Str::lower($carbonDay->format('D'));

        if ($flag == 'checkout') {
            $deliveryDay = $this->getNextCustomTimeDay($carbonDay);
        } else {
            $deliveryDay = $this->times->getActiveCustomTimeByDay($dayCode);
        }

        $times = [];
        $calendarDay = null;
        $selectedTime = null;

        if ($deliveryDay) {
            $calendarDay = Carbon::createFromFormat('D', $deliveryDay->day_code)->format('Y-m-d');
            if ($deliveryDay->is_full_day == 1) {
                $times = [
                    ["time_from" => "12:00 AM", "time_to" => "11:00 PM"]
                ];
                $selectedTime = "11:00 PM";
            } else {
                if ($carbonDay->format('Y-m-d') == date('Y-m-d')) {
                    $times = $this->buildCustomTimes($deliveryDay);
                    $selectedTime = $this->getNearestTime(array_column($times, 'time_to'));
                } else {
                    $times = $deliveryDay->custom_times;
                    $selectedTime = $times[0]['time_to'] ?? null;
                }
            }
        }

        return [
            'times' => $times ?? [],
            'selectedTime' => $selectedTime,
            'calendarDay' => $calendarDay,
        ];
    }

    public function customDeliveryTimes(Request $request)
    {
        $customTime = $this->getCustomDeliveryTimes($request['selected_date']);
        $times = $customTime['times'];
        $selectedTime = $customTime['selectedTime'];
        return view('catalog::frontend.checkout.html.times', compact('times', 'selectedTime'));
    }

    private function getNearestTime($timesList)
    {
        $expected_time = date('Y-m-d H:i');
        $timestamp = strtotime($expected_time);
        $diff = null;
        $index = null;
        if (count($timesList) > 0) {
            foreach ($timesList as $key => $time) {
                $currDiff = abs($timestamp - strtotime($time));
                if (is_null($diff) || $currDiff < $diff) {
                    $index = $key;
                    $diff = $currDiff;
                }
            }
            return $timesList[$index];
        }
        return '';
    }

    private function getNextCustomTimeDay($carbonDay)
    {
        $dayCode =  Str::lower($carbonDay->format('D'));
        $deliveryDay = $this->times->getActiveCustomTimeByDay($dayCode);
        if ($carbonDay->format('Y-m-d') == date('Y-m-d') && (is_null($deliveryDay) || ($deliveryDay && empty($this->buildCustomTimes($deliveryDay))))) {
            $newDateTime = $carbonDay->addDay();
            $deliveryDay = $this->getNextCustomTimeDay($newDateTime);
        }

        return $deliveryDay;
    }

    private function buildCustomTimes($deliveryDay)
    {
        return collect($deliveryDay->custom_times)->map(function ($item) {
            return $item;
        })->reject(function ($item) {
            return strtotime($item['time_from']) < strtotime(date('g:i A'));
        })->values()->toArray();
    }
}

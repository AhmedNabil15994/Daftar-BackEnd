<?php

namespace Modules\DeliveryTime\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DeliveryTime\Http\Requests\Dashboard\DeliveryTimeRequest;
use Modules\DeliveryTime\Repositories\Dashboard\DeliveryTimeRepository as DeliveryTime;

class DeliveryTimeController extends Controller
{
    protected $time;

    function __construct(DeliveryTime $time)
    {
        $this->time = $time;
    }

    public function index()
    {
        $daysQuery = $this->time->getQuery();
        return view('deliverytime::dashboard.times', compact('daysQuery'));
    }

    public function update(DeliveryTimeRequest $request)
    {
        try {
            $update = $this->time->update($request);
            if ($update) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }
            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

}

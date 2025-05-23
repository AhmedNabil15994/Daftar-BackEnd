<?php

namespace Modules\Order\Http\Controllers\Driver;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Order\Transformers\Driver\OrderResource;
use Modules\Order\Repositories\Driver\OrderRepository as Order;
use Modules\Order\Repositories\Dashboard\OrderStatusRepository as OrderStatus;

class OrderController extends Controller
{

    function __construct(Order $order,OrderStatus $status)
    {
        $this->status = $status;
        $this->order  = $order;
    }

    public function index()
    {
        return view('order::driver.orders.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->order->QueryTable($request));

        $datatable['data'] = OrderResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function update(Request $request,$id)
    {
        try {
            $order = $this->order->update($id,$request);

            if ($order) {
                return Response()->json([true , __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        $order    = $this->order->findById($id);
        $statuses = $this->status->getAll();
        return view('order::driver.orders.show',compact('order','statuses'));
    }
}

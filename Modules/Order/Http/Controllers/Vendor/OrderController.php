<?php

namespace Modules\Order\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Order\Notifications\Dashboard\OrderToDriverNotification;
use Modules\Order\Repositories\Vendor\OrderRepository as Order;
use Modules\Order\Repositories\Vendor\OrderStatusRepository as OrderStatus;
use Modules\Order\Transformers\Vendor\OrderResource;
use Notification;

class OrderController extends Controller
{
    protected $status;
    protected $order;

    public function __construct(Order $order, OrderStatus $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    public function index()
    {
        $statuses = $this->status->getAll();

        $successOrders = $this->order->successOrders();
        $failedOrders = $this->order->failedOrders();
        $canceledOrders = $this->order->canceledOrders();
        $returnedOrders = $this->order->returnedOrders();

        return view('order::vendor.orders.index', compact('statuses', 'successOrders', 'failedOrders', 'canceledOrders', 'returnedOrders'));
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->order->QueryTable($request));

        $datatable['data'] = OrderResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function show($id)
    {
        $this->order->updateUnread($id);
        $order = $this->order->findById($id);

        return view('order::vendor.orders.show', compact('order'));
    }

    public function updateBulkDeliveryStatus(Request $request)
    {
        try {
            $updatedOrder = false;
            foreach ($request['ids'] as $id) {
                $order = $this->order->findById($id);
                if (!$order) {
                    return Response()->json([false, __('apps::dashboard.general.message_error')]);
                }

                $updatedOrder = $this->order->updateDeliveryStatus($request, $order);
                if ($updatedOrder && $order->driver) {
                    $this->fireLog($order);
                    Notification::route('mail', $order->driver->driverAccount->email)->notify(
                        (new OrderToDriverNotification($order))->locale(locale())
                    );
                }
            }

            if ($updatedOrder) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function printSelectedItems(Request $request)
    {
        try {
            if (isset($request['ids']) && !empty($request['ids'])) {
                $ids = explode(',', $request['ids']);
                $orders = $this->order->getSelectedOrdersById($ids);
                return view('order::vendor.orders.print', compact('orders'));
            }
            // return Response()->json([false, __('apps::dashboard.general.select_at_least_one_item')]);
        } catch (\PDOException $e) {
            return redirect()->back()->withErrors($e->errorInfo[2]);
        }
    }
}

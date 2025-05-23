<?php

namespace Modules\Order\Http\Controllers\Dashboard;

use Modules\Catalog\Repositories\Dashboard\ProductRepository as Product;
use Modules\Order\Http\Requests\Dashboard\OrderDriverRequest;
use Modules\Order\Repositories\Dashboard\OrderStatusRepository as OrderStatus;
use Modules\Vendor\Repositories\Dashboard\VendorRepository as Vendor;
use Notification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Order\Events\DriverOrder;
use Modules\Order\Transformers\Dashboard\OrderResource;
use Modules\Order\Repositories\Dashboard\OrderRepository as Order;
use Modules\Order\Notifications\Dashboard\OrderToDriverNotification;

//use Modules\Order\Http\Requests\Dashboard\OrderRequest;

class OrderController extends Controller
{
    protected $status;
    protected $order;
    protected $vendor;
    protected $product;

    function __construct(Order $order, OrderStatus $status, Vendor $vendor, Product $product)
    {
        $this->status = $status;
        $this->order = $order;
        $this->vendor = $vendor;
        $this->product = $product;
    }

    public function index()
    {
        $statuses = $this->status->getAll();

        $successOrders = $this->order->successOrders();
        $failedOrders = $this->order->failedOrders();
        $canceledOrders = $this->order->canceledOrders();
        $returnedOrders = $this->order->returnedOrders();

        return view('order::dashboard.orders.index', compact('statuses', 'successOrders', 'failedOrders', 'canceledOrders', 'returnedOrders'));
    }

    public function success()
    {
        $statuses = $this->status->getAll();

        $successOrders = $this->order->successOrders();
        $failedOrders = $this->order->failedOrders();
        $canceledOrders = $this->order->canceledOrders();
        $returnedOrders = $this->order->returnedOrders();

        return view('order::dashboard.orders.success', compact('statuses', 'successOrders', 'failedOrders', 'canceledOrders', 'returnedOrders'));
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->order->QueryTable($request));

        $datatable['data'] = OrderResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function successDatatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->order->QueryTable2($request));

        $datatable['data'] = OrderResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function show($id)
    {
        $order = $this->order->findById($id);
        if (!$order)
            abort(404);

        $this->order->updateUnread($id);
        $statuses = $this->status->getAll();
        $paymentMethods = $this->vendor->getPaymentsMethods();
        return view('order::dashboard.orders.show', compact('order', 'statuses', 'paymentMethods'));
    }

    public function update(OrderDriverRequest $request, $id)
    {
        try {
            $order = $this->order->findById($id);
            if (!$order)
                return Response()->json([false, __('apps::dashboard.general.message_error')]);

            if (in_array($request->order_status, [4, 6, 8]) && $order->order_status_id == 7) { // failed status
                // check if products exist & increase products qty
                $this->updateOrderProductsQty($order, 'increase');
            } elseif (in_array($order->order_status_id, [4, 6, 8]) && $request->order_status == 7) { // success status
                // check if products exist & products qty availability & decrease products qty
                $checkOrderProductsQty = $this->updateOrderProductsQty($order, 'decrease');
                if (gettype($checkOrderProductsQty) == 'string')
                    return Response()->json([false, $checkOrderProductsQty]);
            }

            $check = $this->order->updateDriver($request, $id);
            if ($check) {
                if ($request['user_id']) {
                    if ($order->driver) {
                        $this->fireLog($order);
                        Notification::route('mail', $order->driver->driverAccount->email)->notify(
                            (new OrderToDriverNotification($order))->locale(locale())
                        );
                    }
                }
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function updateBulkDeliveryStatus(Request $request)
    {
        try {
            $updatedOrder = false;
            foreach ($request['ids'] as $id) {
                $order = $this->order->findById($id);
                if (!$order)
                    return Response()->json([false, __('apps::dashboard.general.message_error')]);

                $updatedOrder = $this->order->updateDeliveryStatus($request, $order);
                if ($updatedOrder && $order->driver) {
                    $this->fireLog($order);
                    Notification::route('mail', $order->driver->driverAccount->email)->notify(
                        (new OrderToDriverNotification($order))->locale(locale())
                    );
                }
            }

            if ($updatedOrder)
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->order->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            if (empty($request['ids']))
                return Response()->json([false, __('apps::dashboard.general.select_at_least_one_item')]);

            $deleteSelected = $this->order->deleteSelected($request);
            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function fireLog($order)
    {
        $data = [
            'id' => $order->driver->driverAccount->id,
            'type' => 'driver',
            'url' => url(route('driver.orders.show', $order->id)),
            'description_en' => 'New Order from',
            'description_ar' => 'طلب معاينة جديد من',
        ];

        event(new DriverOrder($data));
    }

    protected function updateOrderProductsQty($order, $flag = '')
    {
        foreach ($order->orderProducts as $orderProduct) {

            if (!empty($orderProduct->orderVariant)) { // variant product
                $product = $this->product->findActiveVariantProductById($orderProduct->orderVariant->product_variant_id ?? null);
                $productType = 'variant';
                $productTitle = $product ? optional(optional($product->product)->translate(locale()))->title . ' - ' . $product->sku : '';
            } else {
                $product = $this->product->findActiveById($orderProduct->product->id ?? null);
                $productType = 'single';
                $productTitle = $product ? optional($product->translate(locale()))->title : '';
            }

            if ($product) {
                $product->product_type = $productType;

                if ($flag == 'increase') {
                    $orderProduct->product()->increment('qty', $orderProduct->qty);
                    $orderProduct->product()->decrement('selling', 1);
                    $variant = $orderProduct->orderVariant;
                    if (!is_null($variant))
                        $variant->variant()->increment('qty', $orderProduct->qty);

                    $order->update([
                        'increment_qty' => true,
                    ]);
                } else {
                    if (intval($product->qty) >= intval($orderProduct->qty)) {
                        $orderProduct->product()->decrement('qty', $orderProduct->qty);
                        $orderProduct->product()->increment('selling', 1);
                        $variant = $orderProduct->orderVariant;
                        if (!is_null($variant))
                            $variant->variant()->decrement('qty', $orderProduct->qty);

                        $order->update([
                            'increment_qty' => false,
                        ]);
                    } else {
                        return __('order::dashboard.order_drivers.validation.qty_is_not_available_for_product') . ' - ' . $productTitle;
                    }
                }
            } else {
                return __('order::dashboard.order_drivers.validation.product_not_found');
            }
        }
        return true;
    }

    public function printSelectedItems(Request $request)
    {
        try {
            if (isset($request['ids']) && !empty($request['ids'])) {
                $ids = explode(',', $request['ids']);
                $orders = $this->order->getSelectedOrdersById($ids);
                return view('order::dashboard.orders.print', compact('orders'));
            }
            // return Response()->json([false, __('apps::dashboard.general.select_at_least_one_item')]);
        } catch (\PDOException $e) {
            return redirect()->back()->withErrors($e->errorInfo[2]);
        }
    }
}

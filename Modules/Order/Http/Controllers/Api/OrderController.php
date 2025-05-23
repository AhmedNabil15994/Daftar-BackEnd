<?php

namespace Modules\Order\Http\Controllers\Api;

use Carbon\Carbon;
use Notification;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Modules\Order\Events\VendorOrder;
use Modules\Order\Events\ActivityLog;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Order\Transformers\Api\OrderResource;
use Modules\Transaction\Services\PaymentService;
use Modules\DeliveryTime\Traits\CheckDateAndTime;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Order\Repositories\Api\OrderRepository as Order;
use Modules\Catalog\Repositories\Api\ProductRepository as Product;
use Modules\DeliveryTime\Entities\CustomDeliveryTime;
use Modules\Order\Notifications\FrontEnd\AdminNewOrderNotification;
use Modules\Order\Notifications\FrontEnd\UserNewOrderNotification;
use Modules\Order\Notifications\FrontEnd\VendorNewOrderNotification;
use Modules\Vendor\Repositories\FrontEnd\VendorRepository as Vendor;
use Modules\Order\Http\Requests\WebService\CreateOrderRequest;
use Illuminate\Support\Str;

class OrderController extends ApiController
{
    use CheckDateAndTime;
    use ShoppingCartTrait;

    protected $vendor;
    protected $order;
    protected $product;
    protected $payment;

    public function __construct(Order $order, PaymentService $payment, Product $product, Vendor $vendor)
    {
        $this->vendor = $vendor;
        $this->order = $order;
        $this->product = $product;
        $this->payment = $payment;
    }

    public function list()
    {
        $orders = $this->order->ordersList();
        return OrderResource::collection($orders);
    }

    public function userOrdersList(Request $request)
    {
        $orders = $this->order->getAllByUser();
        return $this->response(OrderResource::collection($orders));
    }

    public function createOrder(CreateOrderRequest $request)
    {
        $errors = [];
        $errors2 = [];
        $error3 = [];
        $error4 = []; //for diabling cash method

        foreach ($request['product_id'] as $key => $productId) {
            if (isset($request['variation'][$key])) {
                $data['qty'] = $request['qty'][$key];
                $data['variant_id'] = $request['variation'][$key];
                $check = $this->checkVariationValidation($productId, $data);
            } else {
                $data['qty'] = $request['qty'][$key];
                $check = $this->checkProductValidation($productId, json_encode($data));
            }

            if ($check['active_status']) {
                $errors[] = $check['active_status'];
            }

            if ($check['max_qty']) {
                $errors2[] = $check['max_qty'];
            }
        }

        // $error3 = $this->checkTimeSlot($request);
        $dayCode =  Str::lower(Carbon::createFromFormat('Y-m-d', $request['date'])->format('D'));
        $customDeliveryTime = CustomDeliveryTime::where('day_code', $dayCode)->first();
        $checkTimeExist = $this->checkIfTimeAvailable($request['time']['from'], $request['time']['to'], $customDeliveryTime->custom_times ?? []);

        if ((strtotime(date('g:i A')) > strtotime($request['time']['from']) && $request['date'] == date('Y-m-d')) || $request['date'] < date('Y-m-d') || $checkTimeExist == false) {
            $error3[] =  __('catalog::frontend.products.alerts.time_date_not_accepted');
        }

        //disable cash method
        if( $request['payment']=="cash" )
        {
            $error4[] =  __('order::api.payment.validations.cash_method_disabled');
        }

        if ($errors || $errors2 || $error3 || $error4) {
            $invalid = new MessageBag([
                'active_status_products' => $errors,
                'max_qty_products_in_stock' => $errors2,
                'time_not_available' => $error3,
                'cash_disabled' => $error4
            ]);

            return $this->invalidData($invalid, [], 422);
        }

        return $this->checkout($request);
    }

    public function checkVariationValidation($productId, $request)
    {
        $product = $this->product->findById($productId, $request['variant_id']);
        $variationQty = $product ? $product->variantChosed->qty : 0;

        $request = json_encode($request);


        $activeStatus = $this->checkActiveStatus($product, []);
        $maxQty = $this->checkMaxQtyInCheckout($product, json_decode($request), $variationQty);

        return [
            'active_status' => $activeStatus,
            'max_qty' => $maxQty
        ];
    }

    public function checkProductValidation($productId, $request)
    {
        $product = $this->product->findById($productId);
        $productQty = $product ? $product->qty : 0;

        $activeStatus = $this->checkActiveStatus($product, []);
        $maxQty = $this->checkMaxQtyInCheckout($product, json_decode($request), $productQty);

        return [
            'active_status' => $activeStatus,
            'max_qty' => $maxQty
        ];
    }

    public function checkout($request)
    {
        $order = $this->order->create($request);

        if (!$order) {
            return $this->failedToCreateOrder();
        }

        if ($request['payment'] != 'cash') {
            $url = $this->payment->send($order, 'api-orders', $request['payment'], config('setting.other.payment_mode') ?? 'test');

            return $this->response([
                'paymentUrl' => $url,
                'order_id' => $order->id ?? null,
            ]);
        }

        return $this->successOrderDetails($request, $order);
    }

    public function success(Request $request)
    {
        logger('success');
        logger($request->all());

        $orderObject = $this->order->findById($request['OrderID']);
        $order = $this->order->updateOrder($request);

        if ($request['Result'] == 'CAPTURED' && $order == true) {
            $detail = $this->successOrderDetails($request);
            $response = [
                'success' => true,
                'data' => [
                    'id' => $orderObject->id ?? null,
                    // 'id' => $detail->id
                ],
            ];
            return response()->json($response, 200);
        }
        return $this->failedToCreateOrder($orderObject->id ?? null);

        /*$detail = $order == true ? $this->successOrderDetails($request) : $this->failedToCreateOrder();
        $response = [
            'success' => true,
            'data' => [
                'id' => $orderObject->id ?? null,
                // 'id' => $detail->id
            ],
        ];
        return response()->json($response, 200);*/
    }

    public function webhooks(Request $request)
    {
        logger('webhook');
        logger($request->all());

        $order = $this->order->updateOrder($request);
    }

    public function failed(Request $request)
    {
        logger('failed');
        logger($request->all());

        return $this->failedToCreateOrder();
    }

    public function failedToCreateOrder($orderId = null)
    {
        $response = [
            'success' => false,
            'data' => [
                'id' => $orderId,
            ],
        ];
        return response()->json($response, 200);

        /*$error = [
            'failed_to_create_order' => __('order::frontend.orders.index.alerts.order_failed')
        ];
        return $this->invalidData($error, [], 422);*/
    }

    public function successOrderDetails($request, $order = null)
    {
        $orderId = $order ? $order['id'] : $request['OrderID'];
        //        $orderId = $order['id'] ?? ($order->id ?? $request['OrderID']);

        $order = $this->order->findById($orderId);
        if ($order) {
            $this->sendNotifiations($order);
            return new OrderResource($order);
        } else {
            return $this->response(null);
        }
    }

    public function sendNotifiations($order)
    {
        $this->fireLog($order);

        Notification::route('mail', $order->orderAddress->email)->notify(
            (new UserNewOrderNotification($order))->locale(locale())
        );

        Notification::route('mail', config('setting.contact_us.email'))->notify(
            (new AdminNewOrderNotification($order))->locale(locale())
        );
    }

    public function fireLog($order)
    {
        $data = [
            'id' => $order->id,
            'type' => 'orders',
            'url' => url(route('dashboard.orders.show', $order->id)),
            'description_en' => 'New Order',
            'description_ar' => 'طلب جديد ',
        ];

        event(new ActivityLog($data));

        foreach ($order->orderProducts as $prod) {
            $ids[] = $prod->product->vendor_id;
        }

        foreach (array_unique($ids) as $vendorId) {
            $vendor = $this->vendor->findById($vendorId);

            $data2 = [
                'ids' => $vendor['id'],
                'type' => 'vendor',
                'url' => url(route('vendor.orders.show', $order->id)),
                'description_en' => 'New Order',
                'description_ar' => 'طلب جديد',
            ];

            $emails = $vendor->sellers->pluck('email');

            event(new VendorOrder($data2));

            Notification::route('mail', $emails)->notify(
                (new VendorNewOrderNotification($order))->locale(locale())
            );
        }
    }

    public function decrementOrderProductsQty(Request $request, $id)
    {
        $order = $this->order->findById($id);
        if (!$order)
            return $this->invalidData(__('order::api.orders.validations.order_not_found'), [], 422);

        $this->order->decrementOrderProductsQty($order);
        return $this->response(null, __('order::api.orders.validations.order_successfully_updated'));
    }
}

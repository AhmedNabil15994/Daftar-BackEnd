<?php

namespace Modules\Order\Http\Controllers\FrontEnd;

use Carbon\Carbon;
use Cart;
use Notification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Events\ActivityLog;
use Modules\Order\Events\VendorOrder;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Transaction\Services\PaymentService;
use Modules\Order\Http\Requests\FrontEnd\CreateOrderRequest;
use Modules\Order\Repositories\FrontEnd\OrderRepository as Order;
use Modules\Order\Notifications\FrontEnd\AdminNewOrderNotification;
use Modules\Order\Notifications\FrontEnd\UserNewOrderNotification;
use Modules\Order\Notifications\FrontEnd\VendorNewOrderNotification;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Modules\Vendor\Repositories\FrontEnd\VendorRepository as Vendor;
use Illuminate\Support\MessageBag;
use Modules\DeliveryTime\Traits\CheckDateAndTime;
use Modules\DeliveryTime\Entities\CustomDeliveryTime;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use ShoppingCartTrait, CheckDateAndTime;

    protected $payment;
    protected $order;
    protected $vendor;
    protected $product;

    function __construct(Order $order, PaymentService $payment, Product $product, Vendor $vendor)
    {
        $this->payment = $payment;
        $this->order = $order;
        $this->vendor = $vendor;
        $this->product = $product;
        // $this->middleware('csrf', ['except' => ['webhooks']]);
    }

    public function index()
    {
        $orders = $this->order->getAllByUser();
        return view('order::frontend.orders.index', compact('orders'));
    }

    public function invoice($id)
    {
        $order = $this->order->findByIdWithUserId($id);
        if (!$order)
            abort(404);

        return view('order::frontend.orders.invoice', compact('order'));
    }

    public function reOrder($id)
    {
        $order = $this->order->findByIdWithUserId($id);
        if (!$order)
            abort(404);

        return view('order::frontend.orders.re-order', compact('order'));
    }

    public function guestInvoice()
    {
        $order = $this->order->findByIdWithGuestId(session()->get('orderId'));

        if ($order) {
            return view('order::frontend.orders.invoice', compact('order'))->with([
                'alert' => 'success', 'status' => __('order::frontend.orders.index.alerts.order_success')
            ]);
        }

        abort(404);
    }

    public function createOrder(CreateOrderRequest $request)
    {
        $cartProducts = Cart::getContent();

        $errors = [];
        $errors2 = [];
        $errors3 = [];
        $error4 = [];
        $error5 = [];

        foreach ($cartProducts as $key => $cartProduct) {

            $slug = $cartProduct->attributes->slug;
            $request['qty'] = $cartProduct['quantity'];

            if ($cartProduct->attributes->type == 'variants') {
                $request['variant_id'] = $cartProduct->attributes->variant_id;
                $product = $this->product->findBySlugWithoutVendorSlug($slug, $request);

                if ($product) {
                    $varQty = $product->variantChosed->qty;
                } else {
                    $varQty = 0;
                }

                $error3 = $this->productFound($product, $cartProduct);
                $error = $this->checkActiveStatus($product, $request);
                $error2 = $this->checkMaxQtyInCheckout($product, $request, $varQty);
            } else {

                $product = $this->product->findBySlugWithoutVendorSlug($slug, $request);

                if ($product) {
                    $productQty = $product->qty;
                } else {
                    $productQty = 0;
                }

                $error3 = $this->productFound($product, $cartProduct);
                $error = $this->checkActiveStatus($product, $request);
                $error2 = $this->checkMaxQtyInCheckout($product, $request, $productQty);
            }

            if ($error) {
                $errors[] = $error;
            }

            if ($error2) {
                $errors2[] = $error2;
            }

            if ($error3) {
                $errors3[] = $error3;
            }
        }

        // $error4 = $this->checkTimeSlot($request);
        $timeArray = explode(" - ", $request['time']);
        $dayCode =  Str::lower(Carbon::createFromFormat('Y-m-d', $request['date'])->format('D'));
        $customDeliveryTime = CustomDeliveryTime::where('day_code', $dayCode)->first();
        $checkTimeExist = $this->checkIfTimeAvailable($timeArray[0], $timeArray[1], $customDeliveryTime->custom_times ?? []);

        if ((strtotime(date('g:i A')) > strtotime($timeArray[0]) && $request['date'] == date('Y-m-d')) || $request['date'] < date('Y-m-d') || $checkTimeExist == false) {
            $error4 =  __('catalog::frontend.products.alerts.time_date_not_accepted');
        }

        //disable cash method
        if( $request['payment']=="cash" )
        {
            $error5[] =  __('order::api.payment.validations.cash_method_disabled');
        }

        if ($errors || $errors2 || $errors3 || $error4 || $error5) {
            $errors = new MessageBag([
                'productCart' => $errors, 'productCart2' => $errors2, 'productCart3' => $errors3, 'productCart4' => $error4, 'productCart5' => $error5
            ]);

            return redirect()->back()->with(["errors" => $errors]);
        }

        $order = $this->order->create($request);

        if (!$order)
            return $this->redirectToFailedPayment();

        if ($request['payment'] != 'cash')
            return redirect($this->payment->send($order, 'orders', $request['payment'], config('setting.other.payment_mode') ?? 'test'));

        return $this->redirectToPaymentOrOrderPage($request, $order);
    }

    public function success(Request $request)
    {
        logger('success');
        logger($request->all());

        $order = $this->order->updateOrder($request);
        $redirectTo = $order == true ? $this->redirectToPaymentOrOrderPage($request) : $this->redirectToFailedPayment();
        return $redirectTo;
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

        return redirect()->route('frontend.checkout.index')->with([
            'alert' => 'danger', 'status' => __('order::frontend.orders.index.alerts.order_failed')
        ]);
    }

    public function redirectToPaymentOrOrderPage($request, $order = null)
    {
        $orderId = $order ? $order['id'] : $request['OrderID'];
        //        $orderId = $order['id'] ?? ($order->id ?? $request['OrderID']);

        $order = $this->order->findById($orderId);
        if ($order) {
            $this->sendNotifiations($order);
            $this->clearCart();
            return $this->redirectToInvoiceOrder($order);
        } else {
            return $this->redirectToInvoiceOrder(null);
        }
    }

    public function redirectToInvoiceOrder($order)
    {
        if (!is_null($order))
            session()->put('orderId', $order['id']);

        if (auth()->user())
            return redirect()->route('frontend.orders.invoice', $order->id)->with([
                'alert' => 'success', 'status' => __('order::frontend.orders.index.alerts.order_success')
            ]);

        return redirect()->route('frontend.orders.guest.invoice');
    }

    public function redirectToFailedPayment()
    {
        return redirect()->route('frontend.checkout.index')->with([
            'alert' => 'danger', 'status' => __('order::frontend.orders.index.alerts.order_failed')
        ]);
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

    public function pluckVendorEmails($order)
    {
        $emails = $order->vendor->sellers->pluck('email');
        return $emails;
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
}

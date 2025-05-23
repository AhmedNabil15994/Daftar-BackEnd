<?php

namespace Modules\Order\Repositories\FrontEnd;

use Modules\Order\Traits\OrderCalculationTrait;
use Modules\DeliveryTime\Entities\DeliveryTime;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Coupon\Entities\Coupon;
use Modules\Order\Entities\Order;
use Carbon\Carbon;
use Cart;
use Illuminate\Support\Facades\DB;
use Modules\DeliveryTime\Entities\DeliveryStatus;

class OrderRepository
{
    use OrderCalculationTrait, ShoppingCartTrait;

    protected $order;
    protected $coupon;
    protected $times;

    function __construct(Order $order, Coupon $coupon, DeliveryTime $times)
    {
        $this->order   = $order;
        $this->coupon  = $coupon;
        $this->times   = $times;
    }

    public function getAllByUser($order = 'id', $sort = 'desc')
    {
        $orders = $this->order->with(['orderStatus'])->where('user_id', auth()->id())->orderBy($order, $sort)->get();
        return $orders;
    }

    public function getAllFailedOrdersIncrement()
    {
        $orders = $this->order->where('increment_qty', false)
            ->where('created_at', '<', Carbon::now()->subMinutes(15)->toDateTimeString())
            ->get();

        return $orders;
    }

    public function findById($id)
    {
        $order = $this->order->withDeleted()->find($id);
        return $order;
    }

    public function findByIdWithGuestId($id)
    {
        $order = $this->order->withDeleted()->find($id);
        return $order;
    }

    public function findByIdWithUserId($id)
    {
        $order = $this->order->withDeleted()->where('user_id', auth()->id())->find($id);
        return $order;
    }

    public function create($request, $status = false)
    {
        $orderData =  $this->calculateTheOrder();

        // $time = $this->times->find($request['time']);

        DB::beginTransaction();

        try {
            $deliveryStatus = DeliveryStatus::where('flag', 'pending')->first();

            $orderCreated = $this->order->create([
                'date'                       => $request['date'] ? date('Y-m-d', strtotime($request['date'])) : null,
                'time'                       => $request['time'],
                // 'time'                       => $time['from'] . ' - ' . $time['to'],
                'cost_subtotal'              => $orderData['cost_subtotal'],
                'subtotal'                   => $orderData['subtotal'],
                'off'                        => $orderData['off'],
                'shipping'                   => $orderData['shipping'],
                'total'                      => $orderData['total'],
                'cost_total'                 => $orderData['cost_subtotal'],
                'user_id'                    => auth()->user() ? auth()->id() : null,
                'order_status_id'            => ($request['payment'] == 'cash') ? 7 : 8,
                'delivery_status_id'         => $deliveryStatus ? $deliveryStatus->id : null,
                'increment_qty'              => ($request['payment'] == 'cash') ? true : false,
            ]);

            $orderCreated->transactions()->create([
                'method' => $request['payment'],
                'result' => ($request['payment'] == 'cash') ? 'CASH' : null,
            ]);

            $this->createOrderProducts($orderCreated, $orderData, $request);
            $this->createOrderAddress($orderCreated, $orderData);
            $this->createOrderCoupon($orderCreated);

            DB::commit();
            return $orderCreated;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function createOrderProducts($orderCreated, $orderData, $request)
    {
        foreach ($orderData['products'] as $product) {
            $orderProduct = $orderCreated->orderProducts()->create([
                'product_id'                 => $product['product_id'],
                'off'                        => $product['off'],
                'qty'                        => $product['quantity'],
                'price'                      => $product['price'],
                'cost_price'                 => $product['cost_price'],
                'cost_total'                 => $product['cost_total'],
                'total'                      => $product['total_discount'],
                'notes'                      => $product['notes'],
            ]);

            if (!is_null($product['variant']))
                $this->createOrderVariant($orderProduct, $product, $request);
        }

        foreach ($orderCreated->orderProducts as $value) {

            if (is_null($value->orderVariant)) {

                $value->product()->decrement('qty', $value['qty']);
            }

            $value->product()->increment('selling', 1);
        }
    }

    public function createOrderVariant($orderProduct, $product, $request)
    {
        $variant = $orderProduct->orderVariant()->create([
            'product_variant_id'  => $product['variant'],
        ]);

        $variant->variant()->decrement('qty', $product['quantity']);

        foreach ($product['variant_values'] as  $value) {

            $variant->orderVariantValues()->create([
                'product_variant_value_id'   => $value,
            ]);
        }
    }

    public function createOrderCoupon($order)
    {
        if (Cart::getCondition('coupon_discount')) {
            $couponCode = Cart::getCondition('coupon_discount')->getAttributes()['coupon']['code'];

            $coupon = $this->coupon->where('code', $couponCode)->first();

            $order->orderCoupon()->updateOrCreate(
                [
                    'order_id' => $order['id']
                ],
                [
                    'order_id'  => $order['id'],
                    'coupon_id' => $coupon['id']
                ]
            );
        }

        if (Cart::getCondition('coupon_percentage_discount')) {
            $couponCode = Cart::getCondition('coupon_percentage_discount')->getAttributes()['coupon']['code'];

            $coupon = $this->coupon->where('code', $couponCode)->first();

            $order->orderCoupon()->updateOrCreate(
                [
                    'order_id' => $order['id']
                ],
                [
                    'order_id'  => $order['id'],
                    'coupon_id' => $coupon['id']
                ]
            );
        }
    }

    public function createOrderAddress($orderCreated, $orderData)
    {
        $orderCreated->orderAddress()->create([
            'email'                      => $orderData['address']['email'],
            'username'                   => $orderData['address']['username'],
            'mobile'                     => $orderData['address']['mobile'],
            'address'                    => $orderData['address']['address'],
            'block'                      => $orderData['address']['block'],
            'street'                     => $orderData['address']['street'],
            'building'                   => $orderData['address']['building'],
            'state_id'                   => $orderData['address']['state_id'],
        ]);
    }

    public function updateOrder($request)
    {
        $order = $this->findById($request['OrderID']);

        $this->updateQtyOfProduct($order, $request);

        $order->update([
            'order_status_id' => ($request['Result'] == 'CAPTURED') ? 7 : 8,
            'increment_qty'   => true,
        ]);

        $order->transactions()->updateOrCreate(
            [
                'transaction_id'  => $request['OrderID']
            ],
            [
                'auth'          => $request['Auth'],
                'tran_id'       => $request['TranID'],
                'result'        => $request['Result'],
                'post_date'     => $request['PostDate'],
                'ref'           => $request['Ref'],
                'track_id'      => $request['TrackID'],
                'payment_id'    => $request['PaymentID'],
            ]
        );

        return $request['Result'] == 'CAPTURED';
    }

    public function updateQtyOfProduct($order, $request)
    {
        if ($request['Result'] != 'CAPTURED' && $order->increment_qty != true) {

            foreach ($order->orderProducts as $value) {

                $value->product()->increment('qty', $value['qty']);

                $value->product()->decrement('selling', 1);

                $variant = $value->orderVariant;

                if (!is_null($variant))
                    $variant->variant()->increment('qty', $value['qty']);
            }
        }
    }
}

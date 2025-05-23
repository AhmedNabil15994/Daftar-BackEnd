<?php

namespace Modules\Order\Traits;

use Cart;
use Darryldecode\Cart\CartCondition;

trait OrderCalculationTrait
{
    public function calculateTheOrder()
    {
        $data           = [];
        $subtotal       = 0.000;
        $off            = 0.000;
        $cost_subtotal  = 0.000;

        foreach (Cart::getContent() as $value) {

            $p['variant']               = ($value->attributes->type == 'variants') ?
                                                  $value->attributes->variant->id : null;

            $p['variant_values']        = ($value->attributes->type == 'variants') ?
                                           $value->attributes->variant->productValues->pluck('id') : null;

            $p['product_id']            = ($value->attributes->type == 'variants') ?
                                           $value->attributes->product->id : $value->id;

            $p['sku']                   = $value->attributes->sku;
            $p['off']                   = $value->price - $value->getPriceWithConditions();
            $p['quantity']              = $value->quantity;
            $p['price']                 = $value->price;
            $p['price_discount']        = $value->getPriceWithConditions();
            $p['total']                 = $p['price'] * $p['quantity'];
            $p['total_discount']        = $value->getPriceSumWithConditions();
            $p['cost_price']            = $value->attributes->product->cost_price;
            $p['cost_total']            = $p['cost_price'] * $p['quantity'];
            $p['notes']                 = $value->attributes->notes;
            $off            +=  $p['off'];
            $subtotal       +=  $p['total'];
            $cost_subtotal  +=  $p['cost_total'];

            $products[]             = $p;
        }

        $fixed_discount = Cart::getCondition('coupon_discount') ? abs(Cart::getCondition('coupon_discount')->getValue()) : 0.000;

        $final_subtotal = $this->subtotalOrder() - $fixed_discount;

        return $data = [
            'cost_subtotal'     => $cost_subtotal,
            'subtotal'          => $subtotal,
            'subtotal_final'    => $this->subtotalOrder() - $fixed_discount,
            'total'             => $final_subtotal + $this->orderShipping(),
            'off'               => ($fixed_discount > 0) ? $fixed_discount : $subtotal - $final_subtotal,
            'shipping'          => $this->orderShipping(),
            'address'           => $this->orderAddress(),
            'products'          => $products,
        ];
    }

    public function totalOrder()
    {
        return Cart::getTotal();
    }

    public function subtotalOrder()
    {
        return Cart::getSubTotal();
    }

    public function orderShipping()
    {
        return Cart::getCondition('delivery_fees')->getValue();
    }

    public function orderAddress()
    {
        return Cart::getCondition('delivery_fees')->getAttributes()['address'];
    }
}

<?php

namespace Modules\Order\Traits\Api;

use Modules\Catalog\Entities\Product;
use Modules\Area\Entities\State;
use Modules\Coupon\Entities\Coupon;

trait OrderApiCalculationTrait
{
    public function calculateTheOrder($data)
    {
        $state = State::find($data['state_id']);
        $deliveryCharge = $state->deliveryCharge ? $state->deliveryCharge->delivery : config('setting.fiexed_delivery');

        $cost_subtotal = 0.000;
        $subtotal = 0.000;
        $off = 0.000;
        $products = [];

        $coupon = Coupon::where('code', request()->coupon_code)
            ->where('start_at', '<=', date('Y-m-d'))
            ->where('expired_at', '>', date('Y-m-d'))
            ->active()
            ->first();

        foreach ($data['product_id'] as $key => $productId) {

            $p['variant_id'] = isset($data['variation'][$key]) ? $data['variation'][$key] : null;

            $product = $this->fetchProductDetails($productId, $p['variant_id']);

            $p['qty'] = $data['qty'][$key];

            $p['product_id'] = $product->id;

            $p['cost_price'] = $product->cost_price;

            $p['price'] = ($product->variantChosed != null) ?
                $product->variantChosed->price : (
                ($product->offer != null) ? $product->offer->offer_price : $product->price);

            $p['off'] = 0.000;
            if (!is_null($coupon)) {
                if (in_array($productId, $this->getCouponProductsList($coupon, $productId, request()->coupon_code))) {
                    if ($coupon->discount_type == 'value') {
                        $p['off'] = $coupon->discount_value;
                    } else {
                        $p['off'] = (floatval($p['price']) * floatval($coupon->discount_percentage)) / 100;
                    }
                }
            }

            $p['price_after_discount'] = ($p['off'] == 0.000) ? null : ($p['price'] - $p['off']);

            $p['variant_values'] = ($product->variantChosed != null) ?
                $product->variantChosed->productValues->pluck('id') : null;

            $p['cost_total'] = $p['qty'] * $p['cost_price'];
            // $p['total'] = $p['qty'] * $p['price'];
            $p['total'] = !is_null($p['price_after_discount']) ? ($p['qty'] * $p['price_after_discount']) : ($p['qty'] * $p['price']);
            $p['notes'] = $data['notes'][$key];
            $cost_subtotal += $p['cost_total'];
            $subtotal += $p['total'];
            $off += $p['off'];
            $products[] = $p;
        }

        $delivery = $subtotal > config('setting.free_delivery') ? 0.000 : $deliveryCharge;

        return $data = [
            'cost_subtotal' => $cost_subtotal,
            'subtotal' => $subtotal,
            'off' => $off,
            'delivery_fees' => $delivery,
            'order_products' => $products,
            'address' => $this->address($data),
        ];
    }

    /*public function calculateTheOrderOld($data)
    {
        $state = State::find($data['state_id']);
        $deliveryCharge = $state->deliveryCharge ? $state->deliveryCharge->delivery : config('setting.fiexed_delivery');

        $cost_subtotal = 0.000;
        $subtotal = 0.000;
        $off = 0.000;
        $couponTotalPrice = 0;
        $otherCouponTotalPrice = 0;
        $vendorCouponTotalPrice = [];

        $coupon = Coupon::where('code', request()->coupon_code)
            ->where('start_at', '<=', date('Y-m-d'))
            ->where('expired_at', '>', date('Y-m-d'))
            ->active()
            ->first();

        foreach ($data['product_id'] as $key => $productId) {

            $p['variant_id'] = isset($data['variation'][$key]) ? $data['variation'][$key] : null;
            $product = $this->fetchProductDetails($productId, $p['variant_id']);
//            dd($product->vendor->toArray());
            $p['qty'] = $data['qty'][$key];
            $p['product_id'] = $product->id;
            $p['cost_price'] = $product->cost_price;
            $p['price'] = ($product->variantChosed != null) ?
                $product->variantChosed->price : (
                ($product->offer != null) ? $product->offer->offer_price : $product->price);

            $vendorId = !is_null($product->vendor) ? $product->vendor->id : null;
            $vendorCouponTotalPrice[$vendorId][$key] = [
                'product_id' => $p['variant_id'] ?? $product->id,
                'product_type' => $p['variant_id'] ? 'variation' : 'product',
                'amount' => $p['qty'] * floatval($p['price']),
                'price' => floatval($p['price']),
                'qty' => $p['qty'],
            ];
            $p['off'] = 0.000;
            if (!is_null($coupon)) {
                if (in_array($productId, $this->getCouponProductsList($coupon, $productId, request()->coupon_code))) {
                    $vendorCouponTotalPrice[$vendorId][$key]['has_discount'] = true;
                    $couponTotalPrice += $p['qty'] * floatval($p['price']);
                } else {
                    $vendorCouponTotalPrice[$vendorId][$key]['has_discount'] = false;
                    $otherCouponTotalPrice += $p['qty'] * floatval($p['price']);
                }
            } else {
                $vendorCouponTotalPrice[$vendorId][$key]['has_discount'] = false;
            }

            $p['price_after_discount'] = ($p['off'] == 0.000) ? null : ($p['price'] - $p['off']);
            $p['variant_values'] = ($product->variantChosed != null) ?
                $product->variantChosed->productValues->pluck('id') : null;

            $p['cost_total'] = $p['qty'] * $p['cost_price'];
            // $p['total'] = $p['qty'] * $p['price'];
            $p['total'] = !is_null($p['price_after_discount']) ? ($p['qty'] * $p['price_after_discount']) : ($p['qty'] * $p['price']);

            $cost_subtotal += $p['cost_total'];
            $subtotal += $p['total'];
            $off += $p['off'];
            $products[] = $p;
        }

        if (!is_null($coupon) && $couponTotalPrice > 0) {
            if ($coupon->discount_type == 'value') {
                if ($coupon->discount_value > $couponTotalPrice) {
                    $subtotal = $otherCouponTotalPrice;
                } else {
                    $subtotal = ($couponTotalPrice - $coupon->discount_value) + $otherCouponTotalPrice;
                }
            } else {
                $couponValue = $couponTotalPrice * floatval($coupon->discount_percentage) / 100;
                if ($couponValue > $coupon->max_discount_percentage_value) {
                    $subtotal = ($couponTotalPrice - floatval($coupon->max_discount_percentage_value)) + $otherCouponTotalPrice;
                } else {
                    $subtotal = ($couponTotalPrice - $couponValue) + $otherCouponTotalPrice;
                }
            }
        }

        $delivery = $subtotal > config('setting.free_delivery') ? 0.000 : $deliveryCharge;

        return $data = [
            'cost_subtotal' => $cost_subtotal,
            'subtotal' => $subtotal,
            'off' => $off,
            'delivery_fees' => $delivery,
            'order_products' => $products,
            'address' => $this->address($data),
        ];
    }*/

    public function address($data)
    {
        return [
            'building' => $data['building'],
            'block' => $data['block'],
            'street' => $data['street'],
            'address' => $data['address'],
            'state_id' => $data['state_id'],
            'username' => $data['username'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'user_id' => $data['user_id'],
        ];
    }

    static public function fetchProductDetails($id, $variantId)
    {
        return Product::where('status', 1)->where('id', $id)->with([
            'offer' => function ($query) {
                $query->active()->unexpired()->started();
            },
            'variantChosed' => function ($query) use ($variantId) {
                if (!is_null($variantId))
                    $query->where('id', $variantId)->with(['productValues']);
            },
            'vendor' => function ($query) {
                $query->active();
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            },
        ])->first();
    }

    protected function getCouponProductsList($coupon, $productId, $code = '')
    {
        $prdList = [];

        if ($coupon) {
            $coupon_vendors = $coupon->vendors ? $coupon->vendors->pluck('id')->toArray() : [];
            $coupon_products = $coupon->products ? $coupon->products->pluck('id')->toArray() : [];
            $coupon_categories = $coupon->categories ? $coupon->categories->pluck('id')->toArray() : [];
            $flag = $coupon->flag;

            $products = Product::where('status', true);

            if ($flag == 'products') {
                $products = $products->whereIn('id', $coupon_products);
            }

            $products = $products->whereHas('vendor', function ($query) use ($coupon_vendors, $flag) {
                if ($flag == 'vendors') {
                    $query->whereIn('id', $coupon_vendors);
                }
                $query->active();
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            });

            if ($flag == 'categories') {
                $products = $products->whereHas('categories', function ($query) use ($coupon_categories) {
                    $query->active();
                    $query->whereIn('product_categories.category_id', $coupon_categories);
                });
            }

            $prdList = $products->get(['id'])->toArray();
        }

        return array_values(array_column($prdList, 'id'));
    }
}

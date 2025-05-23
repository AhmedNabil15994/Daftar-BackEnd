<?php

namespace Modules\Coupon\Http\Controllers\FrontEnd;

use Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Coupon\Entities\Coupon;
use Darryldecode\Cart\CartCondition;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Coupon\Http\Requests\FrontEnd\CouponRequest;

class CouponController extends Controller
{
    use ShoppingCartTrait;

    public function check_coupon(CouponRequest $request)
    {
        $coupon = Coupon::where('code', $request->code)
            ->where('start_at', '<=', date('Y-m-d'))
            ->where('expired_at', '>', date('Y-m-d'))
            ->active()
            ->first();

        if ($coupon) {

            if ($coupon->discount_type == "value") {
                $this->DiscountCouponCondition($coupon, $coupon->discount_value);
            }

            if ($coupon->discount_type == "percentage") {

                $coupon_discount = new CartCondition([
                    'name' => 'coupon_percentage_discount',
                    'type' => 'coupon_percentage_discount',
                    'value' => '-' . $coupon['discount_percentage'] . '%',
                    'attributes' => [
                        'coupon' => $coupon
                    ]
                ]);

                $this->percentageDiscountCouponCondition($coupon, $coupon->discount_percentage);

                $cartItems = Cart::getContent();
                $prdList = $this->getProductsList($coupon, $coupon->flag);

                $prdListIds = array_values(!empty($prdList) ? array_column($prdList->toArray(), 'id') : []);
                foreach ($cartItems as $cartItem) {
                    if ($cartItem->attributes['type'] == 'variants') {
                        $prdId = $cartItem->attributes->get('product')->id;
                        $cartKey = $cartItem->id;
                    } else
                        $prdId = $cartKey = $cartItem->id;

                    if (in_array($prdId, $prdListIds)) {
                        Cart::addItemCondition($cartKey, $coupon_discount);
                    }
                }

                /*foreach ($cartIds as $id) {
                    if (in_array($id, $prdListIds)) {
                        Cart::addItemCondition($id, $coupon_discount);
                    }
                }*/

                /* $cart_items = Cart::getContent();
                foreach ($cart_items as $item) {
                    Cart::addItemCondition($item['id'], $coupon_discount);
                } */
            }

            return redirect()->route('frontend.checkout.index');
        } else {
            return redirect()->back()->with(['error' => __('coupon::frontend.coupons.validation.code.not_found')]);
        }
    }

    protected function getProductsList($coupon, $flag = 'products')
    {
        $coupon_vendors = $coupon->vendors ? $coupon->vendors->pluck('id')->toArray() : [];
        $coupon_products = $coupon->products ? $coupon->products->pluck('id')->toArray() : [];
        $coupon_categories = $coupon->categories ? $coupon->categories->pluck('id')->toArray() : [];

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

        return $products->get(['id']);
    }
}

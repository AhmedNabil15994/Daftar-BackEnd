<?php

namespace Modules\Coupon\Http\Controllers\WebService;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Http\Requests\WebService\CouponRequest;
use Modules\Coupon\Transformers\WebService\CouponResource;

class CouponController extends ApiController
{
    public function checkCoupon(CouponRequest $request)
    {
        $coupon = Coupon::where('code', $request->code)->active()->first();
        if ($coupon) {
            if ($coupon->start_at > Carbon::now()->format('Y-m-d') || $coupon->expired_at < Carbon::now()->format('Y-m-d'))
                return $this->error(__('coupon::frontend.coupons.validation.code.expired'), [], 422);

            $coupon_users = $coupon->users->pluck('id')->toArray();

            if ($coupon_users <> []) {
                if (auth('api')->check() && !in_array(auth('api')->id(), $coupon_users))
                    return $this->error(__('coupon::frontend.coupons.validation.code.custom'), [], 422);
            }

            /*$prdList = [];
            if (is_null($coupon->flag)) {
                // Check if cart products exist in products table
                $prdList = $this->getProductsList($coupon, array_values($request->product_id));
            } else
                $prdList = $this->getProductsList($coupon, $coupon->flag);*/

            $prdList = $this->getProductsList($coupon, $coupon->flag);

            $intersectIds = array_values(array_intersect(array_column($prdList->toArray(), 'id'), array_values($request->product_id)));
            $prdList = $prdList <> [] ? $intersectIds : [];
            return $this->response(['coupon' => new CouponResource($coupon), 'products' => $prdList]);
        } else {
            return $this->error(__('coupon::frontend.coupons.validation.code.not_found'));
        }
    }

    public function check_coupon_old(CouponRequest $request)
    {
        $coupon = Coupon::where('code', $request->code)->active()->first();
        if ($coupon) {
            if ($coupon->start_at > Carbon::now()->format('Y-m-d') || $coupon->expired_at < Carbon::now()->format('Y-m-d'))
                return response()->json(['error' => __('coupon::frontend.coupons.validation.code.expired')], 422);

            $coupon_vendors = $coupon->vendors->pluck('id')->toArray();
            $coupon_users = $coupon->users->pluck('id')->toArray();
            $coupon_products = $coupon->products->pluck('id')->toArray();
            // $coupon_packages = $coupon->ipackages->pluck('ipackage_id')->toArray();
            $coupon_categories = $coupon->categories->pluck('id')->toArray();

            if ($coupon_vendors <> [] || $coupon_users <> []) {
                $cart_vendor = $request->vendor_id;
                $cart_user = auth('api')->id();
                if (in_array($cart_vendor, $coupon_vendors) == false || in_array($cart_user, $coupon_users) == false)
                    return response()->json(['error' => __('coupon::frontend.coupons.validation.code.custom')], 422);
            }
            if ($coupon->discount_type == "value")
                $discount_value = $coupon->discount_value;
            if ($coupon->discount_type == "percentage") {

                if ($coupon_products <> [] /*|| $coupon_packages <> [] */ || $coupon_categories <> []) {
                    $discount_percentage_value = 0;
                    if ($request['item_id']) {
                        foreach ($request['item_id'] as $key => $id) {
                            if ($request['type'][$key] == 'package') {
                                /* if (in_array($id, $coupon_packages)) {
                                    $discount = ($request['item_total_price'][$key] * $coupon->discount_percentage) / 100;
                                } else {
                                    $discount = 0;
                                } */
                            } else {
                                if (in_array($id, $coupon_products)) {
                                    $discount = ($request['item_total_price'][$key] * $coupon->discount_percentage) / 100;
                                } else {
                                    $discount = 0;
                                }
                            }

                            $discount_percentage_value += $discount;
                        }
                    }
                } else {
                    $discount_percentage_value = ($request->total * $coupon->discount_percentage) / 100;
                }
                if ($discount_percentage_value > $coupon->max_discount_percentage_value)
                    $discount_value = $coupon->max_discount_percentage_value;
                else
                    $discount_value = $discount_percentage_value;
            }

            $total = $request->total - $discount_value;
            if ($total < 0) {
                $total = 0;
            }
            return response()->json(['discount_value' => $discount_value, 'total_after_discount' => $total], 200);
        } else {
            return response()->json(['error' => __('coupon::frontend.coupons.validation.code.not_found')], 404);
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

<?php

namespace Modules\Catalog\Traits;

use Cart;
use Illuminate\Support\MessageBag;
use Darryldecode\Cart\CartCondition;

trait ShoppingCartTrait
{
    protected $vendorCondition = 'vendor';
    protected $deliveryCondition = 'delivery_fees';
    protected $vendorCommission = 'commission';
    protected $DiscountCoupon = 'coupon_discount';

    public function addOrUpdateCart($product, $request)
    {
        $checkQty = $this->checkQty($product);
        // $vendorNotMatch     = $this->vendorExist($product);
        $checkMaxQty = $this->checkMaxQty($product, $request);

        // if ($vendorNotMatch)
        //     return $vendorNotMatch;

        if ($checkQty)
            return $checkQty;

        if ($checkMaxQty)
            return $checkMaxQty;

        // if (!$this->addCartConditions($product))
        //     return false;

        if (!$this->addOrUpdae($product, $request))
            return false;
    }

    public function addOrUpdateCartVariants($product, $request)
    {
        $checkQty = $this->checkQty($product->variantChosed);
        // $vendorNotMatch     = $this->vendorExist($product);
        $checkMaxQty = $this->checkMaxQty($product->variantChosed, $request);

        // if ($vendorNotMatch)
        //     return $vendorNotMatch;

        if ($checkQty)
            return $checkQty;

        if ($checkMaxQty)
            return $checkMaxQty;
        //
        // if (!$this->addCartConditions($product))
        //     return false;

        if (!$this->addOrUpdae($product, $request))
            return false;
    }

    // CHECK IF QTY PRODUCT IN DB IS MORE THAN 0
    public function checkQty($product)
    {
        if ($product->qty <= 0)
            return $errors = new MessageBag([
                'productCart' => __('catalog::frontend.products.alerts.product_qty_less_zero')
            ]);
    }

    // CHECK IF USER REQUESTED QTY MORE THAN MAXIMUAME OF PRODUCT QTY
    public function checkMaxQty($product, $request)
    {
        if ($request->qty > $product->qty)
            return $errors = new MessageBag([
                'productCart' => __('catalog::frontend.products.alerts.qty_more_than_max') . $product->qty
            ]);
    }

    public function productFound($product, $cartProduct)
    {
        if (!$product)
            return $cartProduct->attributes->product->translate(locale())->title . ' - ' .
                __('catalog::frontend.products.alerts.qty_is_not_active');
    }

    public function checkActiveStatus($product, $request)
    {
        if ($product) {

            if ($product->deleted_at != null || $product->status == 0)
                return $product->translate(locale())->title . ' - ' .
                    __('catalog::frontend.products.alerts.qty_is_not_active');

        }
    }

    public function checkMaxQtyInCheckout($product, $request, $qty)
    {
        if ($product) {

            if ($request->qty > $qty)
                return __('catalog::frontend.products.alerts.qty_more_than_max') . ' ' . $qty . ' - ' .
                    $product->translate(locale())->title;

        }

    }

    public function vendorExist($product)
    {
        $vendor = Cart::getCondition('vendor');

        if ($vendor) {
            if (Cart::getCondition('vendor')->getType() != $product->vendor->id)
                return $errors = new MessageBag([
                    'productCart' => __('catalog::frontend.products.alerts.vendor_not_match')
                ]);
        }

        return false;
    }

    public function findItemById($product)
    {
        $item = Cart::getContent()->get($product->id);
        return $item;
    }

    public function addOrUpdae($product, $request)
    {
        $item = $this->findItemById($product);

        if (!is_null($item)) {

            if (!$this->updateCart($product, $request))
                return false;

        } else {

            if (!$this->add($product, $request))
                return false;
        }
    }

    public function add($product, $request)
    {
        if (!is_null($product->variantChosed)) {
            $addToCart = Cart::add([
                'id' => $product->variantChosed->id,
                'name' => $product->translate(locale())->title,
                'price' => $product->variantChosed->price,
                'quantity' => $request->qty ? $request->qty : +1,
                'attributes' => [
                    'type' => 'variants',
                    'variant_id' => $product->variantChosed->id,
                    'sku' => $product->variantChosed->sku,
                    'variant' => $product->variantChosed,
                    'image' => $product->variantChosed->image,
                    'slug' => $product->translate(locale())->slug,
                    'translation' => $product->translations,
                    'old_price' => $product->offer ? $product->price : null,
                    'product' => $product,
                    'notes'     => $request->notes,
                ]
            ]);
        } else {
            $addToCart = Cart::add([
                'id' => $product->id,
                'name' => $product->translate(locale())->title,
                'price' => $product->offer ? $product->offer->offer_price : $product->price,
                'quantity' => $request->qty ? $request->qty : +1,
                'attributes' => [
                    'type' => 'simple',
                    'slug' => $product->translate(locale())->slug,
                    'image' => $product->image,
                    'sku' => $product->sku,
                    'translation' => $product->translations,
                    'old_price' => ($product->offer != null) ? $product->offer->offer_price : $product->price,
                    'product' => $product,
                    'notes'     => $request->notes,
                ]
            ]);
        }


        return $addToCart;
    }

    public function updateCart($product, $request)
    {
        $updateItem = Cart::update($product->id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->qty ? $request->qty : +1,
            ]
        ]);

        if (!$updateItem)
            return false;

        return $updateItem;
    }

    public function addCartConditions($product)
    {
        $orderVendor = new CartCondition([
            'name' => $this->vendorCondition,
            'type' => $product->vendor->id,
            'value' => $product->vendor->order_limit,
            'attributes' => [
                'fixed_delivery' => $product->vendor->fixed_delivery,
            ]
        ]);

        $commissionFromVendor = new CartCondition([
            'name' => $this->vendorCommission,
            'type' => $this->vendorCommission,
            'value' => $product->vendor->commission,
            'attributes' => [
                'commission' => $product->vendor->commission,
                'fixed_commission' => $product->vendor->fixed_commission
            ]
        ]);


        return Cart::condition([$orderVendor, $commissionFromVendor]);
    }

    public function DeliveryChargeCondition($charge, $address)
    {
        if (Cart::getTotal() > config('setting.free_delivery')) {
            $charge = 0.000;
        }

        $deliveryFees = new CartCondition([
            'name' => $this->deliveryCondition,
            'type' => $this->deliveryCondition,
            'target' => 'total',
            'value' => $charge,
            'attributes' => [
                'address' => $address
            ]
        ]);

        return Cart::condition([$deliveryFees]);
    }

    public function DiscountCouponCondition($coupon, $discount_value)
    {
        $coupon_discount = new CartCondition([
            'name' => $this->DiscountCoupon,
            'type' => $this->DiscountCoupon,
            'target' => 'total',
            'value' => $discount_value * -1,
            'attributes' => [
                'coupon' => $coupon
            ]
        ]);

        return Cart::condition([$coupon_discount]);
    }

    public function percentageDiscountCouponCondition($coupon, $discount_value)
    {
        $coupon_discount = new CartCondition([
            'name' => 'coupon_percentage_discount',
            'type' => 'coupon_percentage_discount',
//            'target' => 'total',
            'value' => $discount_value * -1,
            'attributes' => [
                'coupon' => $coupon
            ]
        ]);

        return Cart::condition([$coupon_discount]);
    }

    public function deleteProductFromCart($productId)
    {
        $cartItem = Cart::remove($productId);

        if (count(Cart::getContent()) <= 0)
            return $this->clearCart();

        return $cartItem;
    }

    public function clearCart()
    {
        Cart::clear();
        Cart::clearCartConditions();

        return true;
    }
}

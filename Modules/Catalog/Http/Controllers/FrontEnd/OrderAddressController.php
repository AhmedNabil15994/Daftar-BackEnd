<?php

namespace Modules\Catalog\Http\Controllers\FrontEnd;

use Cart;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Catalog\Http\Requests\FrontEnd\AddAddressRequest;
use Modules\Catalog\Http\Requests\FrontEnd\SelectAddressRequest;
use Modules\Catalog\Http\Requests\FrontEnd\CheckoutLimitationRequest;
use Modules\User\Repositories\FrontEnd\AddressRepository as Address;
use Modules\Vendor\Repositories\FrontEnd\DeliveryChargeRepository as Charge;

class OrderAddressController extends Controller
{
    use ShoppingCartTrait;

    function __construct(Address $address,Charge $charge)
    {
        $this->charge   = $charge;
        $this->address  = $address;
    }

    public function index(Request $request)
    {
        return view('catalog::frontend.address.index');
    }

    public function userDeliveryCharge(SelectAddressRequest $request)
    {
        $address  =  $this->address->findById($request['address']);
        $delivery = $address->state->deliveryCharge ? $address->state->deliveryCharge->delivery : config('setting.fiexed_delivery');

        $charge  = [
            'delivery'  => $delivery
        ];

        $this->DeliveryChargeCondition($charge['delivery'],$address);

        return redirect()->route('frontend.checkout.index');
    }

    public function guestDeliveryCharge(AddAddressRequest $request)
    {
        $delivery = $this->charge->findByStateId($request['state_id']);
        
        $charge = $delivery ? $delivery['delivery'] : config('setting.fiexed_delivery');

        $charge  = [
            'delivery'  => $charge
        ];

        $this->DeliveryChargeCondition($charge['delivery'],$request->except('_token'));

        return redirect()->route('frontend.checkout.index');
    }
}

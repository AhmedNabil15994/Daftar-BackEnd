<?php

namespace Modules\User\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\FrontEnd\UpdateProfileRequest;
use Modules\User\Http\Requests\FrontEnd\UpdateAddressRequest;
use Modules\User\Repositories\FrontEnd\UserRepository as User;
use Modules\User\Repositories\FrontEnd\AddressRepository as Address;

class UserController extends Controller
{

    function __construct(User $user,Address $address)
    {
        $this->user    = $user;
        $this->address = $address;
    }

    public function index()
    {
        return view('user::frontend.profile.index');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $update = $this->user->update($request,auth()->id());

        if ($update)
            return redirect()->back()->with(['alert'=>'success','status'=>__('user::frontend.profile.index.alert.success')]);

        return redirect()->back()->with(['alert'=>'danger','status'=>__('user::frontend.profile.index.alert.error')]);
    }

    public function addresses()
    {
        $addresses = $this->address->getAllByUsrId();
        return view('user::frontend.profile.addresses.index',compact('addresses'));
    }

    public function storeAddress(UpdateAddressRequest $request)
    {
        $update = $this->address->create($request);

        if ($update)
            return redirect()->back()->with(['alert'=>'success','status'=>__('user::frontend.addresses.index.alert.success_')]);

        return redirect()->back()->with(['alert'=>'danger','status'=>__('user::frontend.addresses.index.alert.error')]);
    }

    public function editAddress($id)
    {
        $address = $this->address->findById($id);
        return view('user::frontend.profile.addresses.address',compact('address'));
    }

    public function updateAddress(UpdateAddressRequest $request,$id)
    {
        $update = $this->address->update($request,$id);

        if ($update)
            return redirect()->back()->with(['alert'=>'success','status'=>__('user::frontend.addresses.index.alert.success')]);

        return redirect()->back()->with(['alert'=>'danger','status'=>__('user::frontend.addresses.index.alert.error')]);
    }

    public function deleteAddress($id)
    {
        $update = $this->address->delete($id);

        if ($update)
            return redirect()->back();

        return redirect()->back()->with(['alert'=>'danger','status'=>__('user::frontend.addresses.index.alert.error')]);
    }
}

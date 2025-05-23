<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\User\Transformers\Api\AddressResource;
use Modules\User\Repositories\Api\AddressRepository as Address;
use Modules\Apps\Http\Controllers\Api\ApiController;

class AddressController extends ApiController
{
    function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function profile()
    {
        $address =  $this->address->list();
        return $this->response(AddressResource::collection($address));
    }

    public function add(Request $request)
    {
        $address = $this->address->create($request);
        return $this->response(new AddressResource($address));
    }

    public function edit(Request $request,$id)
    {
        $this->address->edit($request,$id);

        $address = $this->address->findByid($id);
        return $this->response(new AddressResource($address));
    }

    public function delete(Request $request,$id)
    {
        $address = $this->address->delete($request,$id);
        return $this->response([]);
    }
}

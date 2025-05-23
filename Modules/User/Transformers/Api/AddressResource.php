<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class AddressResource extends Resource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'block'         => $this->block,
           'street'        => $this->street,
           'building'      => $this->building,
           'address'       => $this->address,
           'mobile'        => $this->mobile,
           'username'      => $this->username,
           'email'         => $this->email,
           'state'         => $this->state->translate(locale())->title,
           'state_id'      => $this->state_id,
       ];
    }
}

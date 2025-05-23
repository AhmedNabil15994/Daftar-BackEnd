<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;

class DeliveryCharge extends Model
{
    protected $fillable = ['delivery','state_id'];

    public function state()
    {
        return $this->belongsTo(\Modules\Area\Entities\State::class);
    }
}

<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $fillable = ['email','username','mobile','block','street','building','address','state_id','order_id'];
    // protected $with 		= ['state'];


    public function state()
    {
        return $this->belongsTo(\Modules\Area\Entities\State::class);
    }
}

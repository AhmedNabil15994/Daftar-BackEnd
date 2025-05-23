<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderCoupon extends Model
{
    protected $fillable = ['order_id','coupon_id'];
    protected $table    = 'order_coupon';


    public function order()
    {
        return $this->belongsTo(\Modules\Area\Entities\State::class);
    }

    public function coupon()
    {
        return $this->belongsTo(\Modules\Coupon\Entities\Coupon::class);
    }
}

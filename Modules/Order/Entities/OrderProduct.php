<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Product;

class OrderProduct extends Model
{

    // protected $with 	= ['product'];

    protected $fillable = [
      'price',
      'cost_price',
      'off',
      'qty',
      'total',
      'cost_total',
      'product_id',
      'order_id',
      'notes',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }


    public function orderVariant()
    {
        return $this->hasOne(OrderVariant::class);
    }
}

<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;

class VendorRate extends Model
{
    protected $fillable = ['rate' , 'vendor_id' , 'order_id'];
}

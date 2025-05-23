<?php

namespace Modules\DeliveryTime\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class CustomDeliveryTime extends Model
{
    use ScopesTrait;

    protected $guarded = ['id'];
    protected $casts = [
        "custom_times" => "array"
    ];

}

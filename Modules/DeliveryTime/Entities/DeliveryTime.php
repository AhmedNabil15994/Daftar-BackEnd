<?php

namespace Modules\DeliveryTime\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class DeliveryTime extends Model
{
    use SoftDeletes , ScopesTrait;

    protected $fillable = ['from','to','status','last_order'];
}

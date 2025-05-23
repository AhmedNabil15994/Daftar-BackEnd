<?php

namespace Modules\Advertising\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Advertising extends Model
{
    use SoftDeletes, ScopesTrait;

    protected $table = 'advertising';
    protected $guarded = ['id'];

    protected $appends = ['morph_model'];

    public function getMorphModelAttribute()
    {
        return !is_null($this->advertable) ? (new \ReflectionClass($this->advertable))->getShortName() : null;
    }

    public function advertable()
    {
        return $this->morphTo();
    }

    public function advertGroup()
    {
        return $this->belongsTo(AdvertisingGroup::class, 'ad_group_id');
    }

}

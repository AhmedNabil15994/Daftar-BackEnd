<?php

namespace Modules\Area\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class State extends Model implements TranslatableContract
{
    use Translatable , SoftDeletes , ScopesTrait;

    protected $with 					    = ['translations'];
  	protected $fillable 					= ['status' , 'city_id'];
  	public $translatedAttributes 	        = [ 'title' , 'slug' ];
    public $translationModel 			    = StateTranslation::class;

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function deliveryCharge()
    {
        return $this->hasOne(\Modules\Vendor\Entities\DeliveryCharge::class);
    }
}

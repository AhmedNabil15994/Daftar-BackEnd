<?php

namespace Modules\Order\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class OrderStatus extends Model implements TranslatableContract
{
  	use Translatable , ScopesTrait;

    protected $with               = ['translations'];
  	protected $fillable 					= ['color_label','success_status' , 'failed_status'];
  	public $translatedAttributes 	= ['title'];
    public $translationModel 			= OrderStatusTranslation::class;

}

<?php

namespace Modules\DeliveryTime\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class DeliveryStatus extends Model implements TranslatableContract
{
	use Translatable, ScopesTrait;

	protected $with = ['translations'];
	protected $guarded = ['id'];
	public $translatedAttributes = ['title'];
	public $translationModel = DeliveryStatusTranslation::class;
}

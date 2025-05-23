<?php

namespace Modules\Area\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Country extends Model implements TranslatableContract
{
  	use Translatable , SoftDeletes , ScopesTrait;

    protected $with 					    = ['translations'];
  	protected $fillable 					= ['status'];
  	public $translatedAttributes 	= [ 'title' , 'slug' ];
    public $translationModel 			= CountryTranslation::class;

}

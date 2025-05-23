<?php

namespace Modules\Variation\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class Option extends Model implements TranslatableContract
{
  	use Translatable , SoftDeletes , ScopesTrait;

    protected $hidden             = ["created_at", "updated_at" , 'deleted_at'];
    protected $with               = ['translations'];
  	protected $fillable 		  = ['status'];
  	public $translatedAttributes  = ['title'];
    public $translationModel 	  = OptionTranslation::class;

    public function values()
    {
        return $this->hasMany(OptionValue::class);
    }
}

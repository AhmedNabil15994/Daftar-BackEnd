<?php

namespace Modules\Area\Entities;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    protected $fillable = [ 'title' , 'slug' ];
}

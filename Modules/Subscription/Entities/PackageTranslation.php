<?php

namespace Modules\Subscription\Entities;

use Illuminate\Database\Eloquent\Model;

class PackageTranslation extends Model
{
    protected $fillable = ['description' , 'title' , 'slug' , 'seo_description' , 'seo_keywords'];
}

<?php

namespace Modules\Vendor\Entities;

use Illuminate\Database\Eloquent\Model;

class VendorTranslation extends Model
{
    protected $fillable = ['description' , 'title' , 'slug' , 'seo_description' , 'seo_keywords'];
}

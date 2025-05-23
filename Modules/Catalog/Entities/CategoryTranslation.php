<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $fillable = [ 'title' , 'slug' , 'seo_description' , 'seo_keywords'];
}

<?php

namespace Modules\Catalog\Entities;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasSlug;

    protected $fillable = [ 'title' , 'description' , 'slug' , 'seo_description' , 'seo_keywords'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->usingLanguage('ar');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

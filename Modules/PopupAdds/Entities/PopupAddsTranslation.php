<?php

namespace Modules\PopupAdds\Entities;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class PopupAddsTranslation extends Model
{
    use HasSlug;

    protected $table = 'popup_adds_translations';
    public $timestamps = false;
    protected $fillable = [
        'title', 'short_description', 'slug',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

<?php

namespace Modules\PopupAdds\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class PopupAdds extends Model
{
    use Translatable, SoftDeletes, ScopesTrait;

    protected $with = ['translations'];
    protected $table = 'popup_adds';
    protected $guarded = ['id'];
    public $translatedAttributes = ['title', 'short_description', 'slug'];
    public $translationModel = PopupAddsTranslation::class;
    public $translationForeignKey = 'popup_adds_id';
    protected $appends = ['morph_model'];

    public function getMorphModelAttribute()
    {
        return !is_null($this->popupable) ? (new \ReflectionClass($this->popupable))->getShortName() : null;
    }

    public function popupable()
    {
        return $this->morphTo();
    }

    public function scopeSortAsc($query)
    {
        return $query->orderBy('sort', 'asc');
    }

    public function scopeSortDesc($query)
    {
        return $query->orderBy('sort', 'desc');
    }
}

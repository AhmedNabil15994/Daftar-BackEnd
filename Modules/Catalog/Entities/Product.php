<?php

namespace Modules\Catalog\Entities;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;
use Modules\PopupAdds\Entities\PopupAdds;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model implements TranslatableContract
{
    use Translatable, SoftDeletes, ScopesTrait;
    use Sortable;

    protected $with = ['translations'];

    protected $fillable = [
        'status',
        'selling',
        'image',
        'price',
        'cost_price',
        'sku',
        'qty',
        'vendor_id',
        'brand_id',
        'most_popular',
        'new_arrival',
        'sort',
    ];

    public $sortable = ['id', 'sort', 'created_at', 'updated_at'];

    public $translatedAttributes = ['title', 'description', 'slug', 'seo_description', 'seo_keywords'];
    public $translationModel = ProductTranslation::class;


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function offer()
    {
        return $this->hasOne(ProductOffer::class, 'product_id');
    }

    public function newArrival()
    {
        return $this->hasOne(ProductNewArrival::class, 'product_id');
    }

    public function vendor()
    {
        return $this->belongsTo(\Modules\Vendor\Entities\Vendor::class);
    }

    public function options()
    {
        return $this->hasMany(\Modules\Variation\Entities\ProductOption::class);
    }

    public function variants()
    {
        return $this->hasMany(\Modules\Variation\Entities\ProductVariant::class);
    }

    public function variantChosed()
    {
        return $this->hasOne(\Modules\Variation\Entities\ProductVariant::class);
    }

    public function variantValues()
    {
        return $this->hasMany(\Modules\Variation\Entities\ProductVariantValue::class);
    }

    public function orders()
    {
        return $this->hasMany(\Modules\Order\Entities\OrderProduct::class);
    }

    public function checkIfHaveOption($optionId)
    {
        return $this->variantValues->contains('option_value_id', $optionId);
    }

    public function popupAdds()
    {
        return $this->morphToMany(PopupAdds::class, 'popupable', 'popup_adds');
    }
}

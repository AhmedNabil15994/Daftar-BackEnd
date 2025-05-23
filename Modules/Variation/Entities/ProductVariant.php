<?php

namespace Modules\Variation\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\ScopesTrait;

class ProductVariant extends Model
{
    use ScopesTrait;

    protected $fillable = ['product_id', 'sku', 'price', 'status', 'qty', 'image'];

    public function productValues()
    {
        return $this->hasMany(ProductVariantValue::class);
    }

    public function product()
    {
        return $this->belongsTo(\Modules\Catalog\Entities\Product::class);
    }
}

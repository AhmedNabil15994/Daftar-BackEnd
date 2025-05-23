<?php

namespace Modules\Variation\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductVariantValue extends Model
{
    protected $hidden             = ["created_at" , "updated_at" , 'deleted_at' , 'option_value_id' , 'product_id' , 'product_variant_id'];
    protected $fillable = ['option_value_id','product_id','product_variant_id'];

    public function product()
    {
        return $this->belongsTo(\Modules\Catalog\Entities\Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class);
    }
}

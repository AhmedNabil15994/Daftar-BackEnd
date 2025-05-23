<?php

namespace Modules\Catalog\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [ 'product_id' , 'image'];
}

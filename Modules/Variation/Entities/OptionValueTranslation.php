<?php

namespace Modules\Variation\Entities;

use Illuminate\Database\Eloquent\Model;

class OptionValueTranslation extends Model
{
    protected $hidden             = ["created_at", "updated_at" , 'id' , 'option_value_id'];
    protected $fillable = ['title'];
}

<?php

namespace Modules\Variation\Entities;

use Illuminate\Database\Eloquent\Model;

class OptionTranslation extends Model
{
    protected $hidden             = ["created_at", "updated_at" , 'id' , 'option_id'];
    protected $fillable           = ['title'];
}

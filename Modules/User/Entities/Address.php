<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['email','username','mobile','block','street','building','address','state_id','user_id'];

    public function state()
    {
        return $this->belongsTo(\Modules\Area\Entities\State::class);
    }
}

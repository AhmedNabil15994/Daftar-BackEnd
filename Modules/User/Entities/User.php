<?php

namespace Modules\User\Entities;

use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Core\Traits\ScopesTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    // protected $with   = ['roles'];

    use Notifiable, ScopesTrait, HasApiTokens;

    /*use EntrustUserTrait {
      restore as private restoreA;
    }
    use SoftDeletes {
      restore as private restoreB;
    }*/

    use EntrustUserTrait {
        EntrustUserTrait::restore as private restoreA;
    }
    use SoftDeletes {
        EntrustUserTrait::restore as private restoreB;
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*public function getImageAttribute($value)
    {
        return !is_null($value) ? config('core.config.user_img_path') . '/' . $value : null;
    }*/

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function driverOrders()
    {
        return $this->hasMany(\Modules\Order\Entities\OrderDriver::class);
    }
}

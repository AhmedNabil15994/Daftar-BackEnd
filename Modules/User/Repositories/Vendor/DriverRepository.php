<?php

namespace Modules\User\Repositories\Vendor;

use Modules\Core\Traits\CoreTrait;
use Modules\User\Entities\User;

class DriverRepository
{
    use CoreTrait;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /*
     * Get All Normal Users with Driver Roles
     */
    public function getAllDrivers($order = 'id', $sort = 'desc')
    {
        $users = $this->user->whereHas('roles.perms', function ($query) {
            $query->where('name', 'driver_access');
        })->orderBy($order, $sort)->get();
        return $users;
    }

    /*
     * Find Object By ID
     */
    public function findById($id)
    {
        $user = $this->user->withDeleted()->find($id);
        return $user;
    }

    /*
     * Find Object By ID
     */
    public function findByEmail($email)
    {
        $user = $this->user->where('email', $email)->first();
        return $user;
    }

}

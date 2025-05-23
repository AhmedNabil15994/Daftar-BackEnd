<?php

namespace Modules\DeviceToken\Repositories\Dashboard;

use Modules\DeviceToken\Entities\DeviceToken;
use Hash;
use DB;

class DeviceTokenRepository
{
    protected $token;

    function __construct(DeviceToken $token)
    {
        $this->token = $token;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $tokens = $this->token->where('device_token', '!=', null)->orderBy($order, $sort)->get();
        return $tokens;
    }
}

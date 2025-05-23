<?php

namespace Modules\DeviceToken\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\DeviceToken\Repositories\Api\DeviceTokenRepository;

class DeviceTokenController extends ApiController
{
    protected $token;

    function __construct(DeviceTokenRepository $token)
    {
        $this->token = $token;
    }

    public function create(Request $request)
    {
        $token = $this->token->create($request);
        return $this->response([]);
    }
}

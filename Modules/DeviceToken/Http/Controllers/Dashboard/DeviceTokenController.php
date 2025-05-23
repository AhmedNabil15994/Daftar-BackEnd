<?php

namespace Modules\DeviceToken\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DeviceToken\Http\Requests\Dashboard\SendNotificationRequest;
use Modules\DeviceToken\Services\FCM;
use Modules\DeviceToken\Repositories\Dashboard\DeviceTokenRepository;

class DeviceTokenController extends Controller
{
    protected $token;
    protected $fcm;

    function __construct(DeviceTokenRepository $token, FCM $fcm)
    {
        $this->token = $token;
        $this->fcm = $fcm;
    }

    public function index()
    {
        return view('devicetoken::dashboard.index');
    }

    public function send(SendNotificationRequest $request)
    {
        $devices = $this->token->getAll();
        if ($devices->count() > 0) {
            $this->fcm->send($devices, $request->except('_token'));
            return Response()->json([true, __('apps::dashboard.messages.created')]);
        }
        return Response()->json([false, __('apps::dashboard.messages.no_devices')]);
    }
}

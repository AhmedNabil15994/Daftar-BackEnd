<?php

namespace Modules\DeviceToken\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DeviceToken\Traits\FCMTrait;
use Modules\DeviceToken\Jobs\FirebaseMessage;
use Modules\DeviceToken\Repositories\Dashboard\DeviceTokenRepository;

class DeviceTokenController2 extends Controller
{
    use FCMTrait;

    function __construct(DeviceTokenRepository $token)
    {
        $this->token = $token;
    }

    public function index()
    {
        return view('devicetoken::dashboard.index');
    }

    public function send(Request $request)
    {
        $devices['ios']     =  $this->token->getAll('IOS');

        $devices['android'] =  $this->token->getAll('ANDROID');

        $data = $request->except('_token');

        FirebaseMessage::dispatch($devices,$data);

        return Response()->json([true , __('apps::dashboard.messages.created')]);
    }
}

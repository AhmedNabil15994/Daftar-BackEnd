<?php

namespace Modules\Authentication\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\FrontEnd\RegisterRequest;
use Modules\Authentication\Repositories\FrontEnd\AuthenticationRepository as AuthenticationRepo;

class RegisterController extends Controller
{
    use Authentication;

    function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function show(Request $request)
    {
        return view('authentication::frontend.auth.register' , compact('request'));
    }

    public function register(RegisterRequest $request)
    {
        $registered = $this->auth->register($request);

        if ($registered):

            $this->loginAfterRegister($request);

            return $this->redirectTo($request);

        else:

            return redirect()->back()->with(['errors'=>'try again']);

        endif;

    }

    public function redirectTo($request)
    {
        if ($request['redirect_to'] == 'address')
            return redirect()->route('frontend.order.address.index');


        return redirect()->route('frontend.home');
    }
}

<?php

namespace Modules\Authentication\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\FrontEnd\ResetPasswordRequest;
use Modules\Authentication\Repositories\FrontEnd\AuthenticationRepository as AuthenticationRepo;

class ResetPasswordController extends Controller
{
    use Authentication;

    function __construct(AuthenticationRepo $auth)
    {
        $this->auth = $auth;
    }

    public function resetPassword($token)
    {
        return view('authentication::frontend.auth.passwords.reset',compact('token'));
    }


    public function updatePassword(ResetPasswordRequest $request)
    {
        $reset = $this->auth->resetPassword($request);

        $errors =  $this->login($request);

        if ($errors)
            return redirect()->back()->withErrors($errors)->withInput($request->except('password'));

        return redirect()->route('frontend.home')->with(['status'=>'Password Reset Successfully']);
    }
}

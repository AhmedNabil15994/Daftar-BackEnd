<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\User\Transformers\Api\UserResource;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Foundation\Authentication;
use Modules\Authentication\Http\Requests\Api\LoginRequest;

class LoginController extends ApiController
{
    use Authentication;

    public function postLogin(LoginRequest $request)
    {
        $failedAuth =  $this->login($request);
        if ($failedAuth)
            return $this->invalidData($failedAuth, [], 422);

        return $this->tokenResponse();
    }

    public function tokenResponse($user = null)
    {
        $user = $user ? $user : auth()->user();

        $token = $this->generateToken($user);

        return $this->response([
            'access_token' => $token->accessToken,
            'user'         => new UserResource($user),
            'token_type'   => 'Bearer',
            'expires_at'   => $this->tokenExpiresAt($token)
        ]);
    }

    public function logout(Request $request)
    {
        $user = auth()->user()->token()->revoke();

        return $this->response([], __('authentication::api.logout.messages.success') );
    }
}

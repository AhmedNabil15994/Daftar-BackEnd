<?php

namespace Modules\User\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\User\Transformers\Api\UserResource;
use Modules\User\Http\Requests\Api\UpdateProfileRequest;
use Modules\User\Http\Requests\Api\ChangePasswordRequest;
use Modules\User\Repositories\Api\UserRepository as User;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Illuminate\Support\Str;

class UserController extends ApiController
{
    protected $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }

    public function profile()
    {
        $user =  $this->user->userProfile();
        return $this->response(new UserResource($user));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->user->update($request);

        $user =  $this->user->userProfile();

        return $this->response(new UserResource($user));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->user->changePassword($request);

        $user =  $this->user->findById(auth()->id());

        return $this->response(new UserResource($user));
    }

    public function deleteUserAccount(Request $request)
    {
        $user = $this->user->findById(auth()->id());
        if (!$user) {
            return $this->error(__('user::api.users.alerts.user_not_found'));
        }
        $prefix = 'toc_' . $user->id . '_';

        if (Str::startsWith($user->email, $prefix) || Str::startsWith($user->mobile, $prefix))
            return $this->error(__('user::api.users.alerts.user_deleted_before'));

        $email = $prefix . $user->email;
        $mobile = $prefix . $user->mobile;

        $user->update([
            'email' => $email,
            'mobile' => $mobile,
        ]);
        // $user->fresh();
        auth()->user()->token()->revoke(); // logout user
        return $this->response([], __('user::api.users.alerts.user_deleted_successfully'));
    }
}

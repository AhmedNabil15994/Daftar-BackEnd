<?php

namespace Modules\User\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\User\Http\Requests\Dashboard\UserRequest;
use Modules\User\Transformers\Dashboard\UserResource;
use Modules\User\Repositories\Dashboard\UserRepository as User;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;

class UserController extends Controller
{

    function __construct(User $user , Role $role)
    {
        $this->role = $role;
        $this->user = $user;
    }

    public function edit($id)
    {
        ($id != auth()->id()) ? abort(404) : null;

        $user = $this->user->findById($id);
        $roles = $this->role->getAll('id','asc');

        return view('user::vendor.users.edit',compact('user','roles'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $update = $this->user->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

<?php

namespace Modules\User\Repositories\FrontEnd;

use Modules\User\Entities\User;
use Hash;
use DB;

class UserRepository
{

    function __construct(User $user)
    {
        $this->user      = $user;
    }

    public function update($request,$id)
    {
        DB::beginTransaction();

        $user = $this->user->find($id);
        $restore = $request->restore ? $this->restoreSoftDelte($user) : null;

        try {

          $image = $request['image'] ? path_without_domain($request['image']) : $user->image;

          if ($request['password'] == null)
              $password = $user['password'];
          else
              $password  = Hash::make($request['password']);

            $user->update([
                'name'          => $request['name'],
                'email'         => $request['email'],
                'mobile'        => $request['mobile'],
                'password'      => $password,
                'image'         => $image,
            ]);

            if($request['roles'] != null)
            {
                DB::table('role_user')->where('user_id',$id)->delete();

                foreach ($request['roles'] as $key => $value) {
                    $user->attachRole($value);
                }
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }
}

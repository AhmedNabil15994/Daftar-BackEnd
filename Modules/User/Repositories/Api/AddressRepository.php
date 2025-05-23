<?php

namespace Modules\User\Repositories\Api;

use Modules\User\Entities\Address;
use Hash;
use DB;

class AddressRepository
{

    function __construct(Address $address)
    {
        $this->address  = $address;
    }

    public function findByid($id)
    {
        return $this->address->where('user_id',auth()->id())->find($id);
    }

    public function list()
    {
        return $this->address->orderBy('id','DESC')->with('state')->where('user_id',auth()->id())->get();
    }
    
    public function create($request)
    {
        DB::beginTransaction();

        try {

            $address = $this->address->create([
               'block'         => $request->block,
               'street'        => $request->street,
               'building'      => $request->building,
               'address'       => $request->address,
               'mobile'        => $request->mobile,
               'username'      => $request->username,
               'email'         => $request->email,
               'state_id'      => $request->state_id,
               'user_id'       => auth()->id(),
            ]);

            DB::commit();
            return $address;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function edit($request,$id)
    {
        $address = $this->findByid($id);

        DB::beginTransaction();

        try {

            $address->update([
               'block'         => $request->block,
               'street'        => $request->street,
               'building'      => $request->building,
               'address'       => $request->address,
               'mobile'        => $request->mobile,
               'username'      => $request->username,
               'email'         => $request->email,
               'state_id'      => $request->state_id,
               'user_id'       => auth()->id(),
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function delete($request,$id)
    {
        $address = $this->findByid($id);

        DB::beginTransaction();

        try {

            $address->delete();

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }
}

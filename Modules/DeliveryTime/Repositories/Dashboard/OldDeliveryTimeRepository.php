<?php

namespace Modules\DeliveryTime\Repositories\Dashboard;

use Modules\DeliveryTime\Entities\DeliveryTime;
use Hash;
use DB;

class OldDeliveryTimeRepository
{

    function __construct(DeliveryTime $time)
    {
        $this->time   = $time;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $times = $this->time->active()->orderBy($order, $sort)->get();
        return $times;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $times = $this->time->orderBy($order, $sort)->get();
        return $times;
    }

    public function findById($id)
    {
        $time = $this->time->withDeleted()->find($id);
        return $time;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

          $time = $this->time->create([
            'status'   => $request->status ? 1 : 0,
            'from'     => $request->delivery_from,
            'last_order'     => $request->last_order,
            'to'       => $request->delivery_to,
          ]);

          DB::commit();
          return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function update($request,$id)
    {
        DB::beginTransaction();

        $time = $this->findById($id);

        $restore = $request->restore ? $this->restoreSoftDelte($time) : null;

        try {

            $time->update([
              'status'   => $request->status ? 1 : 0,
              'from'     => $request->delivery_from,
              'last_order'     => $request->last_order,
              'to'       => $request->delivery_to,
            ]);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);

            if ($model->trashed()):
              $model->forceDelete();
            else:
              $model->delete();
            endif;

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->time->where(function($query) use($request){
                      $query->where('id', 'like' , '%'. $request->input('search.value') .'%');
                 });

        $query = $this->filterDataTable($query,$request);

        return $query;
    }

    public function filterDataTable($query,$request)
    {
        // Search DeliveryTimes by Created Dates
        if (isset($request['req']['from']))
            $query->whereDate('created_at'  , '>=' , $request['req']['from']);

        if (isset($request['req']['to']))
            $query->whereDate('created_at'  , '<=' , $request['req']['to']);

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) &&  $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) &&  $request['req']['status'] == '0')
            $query->unactive();

        return $query;
    }

}

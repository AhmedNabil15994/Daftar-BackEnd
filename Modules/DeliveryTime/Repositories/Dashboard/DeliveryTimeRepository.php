<?php

namespace Modules\DeliveryTime\Repositories\Dashboard;

use Modules\DeliveryTime\Entities\CustomDeliveryTime;
use Illuminate\Support\Facades\DB;

class DeliveryTimeRepository
{
    protected $time;

    function __construct(CustomDeliveryTime $time)
    {
        $this->time   = $time;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $times = $this->time->active()->orderBy($order, $sort)->get();
        return $times;
    }

    public function getQuery($order = 'id', $sort = 'desc')
    {
        return $this->time->orderBy($order, $sort)->get();
    }

    public function findById($id)
    {
        $time = $this->time->withDeleted()->find($id);
        return $time;
    }

    public function update($request)
    {
        DB::beginTransaction();

        try {

            if (isset($request->days_status) && !empty($request->days_status)) {
                $this->updateWorkTimes($request->days_status, $request->is_full_day, $request->availability);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    private function updateWorkTimes($days_status, $is_full_day, $availability)
    {
        // START Edit Work Times Over Weeks
        $deletedWorkTimes = $this->syncRelationModel(new CustomDeliveryTime, 'day_code', $days_status);
        foreach ($days_status as $k => $dayCode) {
            if (array_key_exists($dayCode, $is_full_day)) {
                if ($is_full_day[$dayCode] == '1') {
                    $availabilityArray = [
                        'day_code' => $dayCode,
                        'status' => true,
                        'is_full_day' => true,
                        'custom_times' => null,
                    ];
                    CustomDeliveryTime::updateOrCreate(['day_code' => $dayCode], $availabilityArray);
                } else {
                    $works = [
                        'day_code' => $dayCode,
                        'status' => true,
                        'is_full_day' => false,
                    ];

                    foreach ($availability['time_from'][$dayCode] as $key => $time) {
                        $works['custom_times'][] = [
                            'time_from' => $time,
                            'time_to' => $availability['time_to'][$dayCode][$key],
                        ];
                    }
                    CustomDeliveryTime::updateOrCreate(['day_code' => $dayCode], $works);
                }
            }
        }

        if (!empty($deletedWorkTimes['deleted'])) {
            CustomDeliveryTime::whereIn('day_code', $deletedWorkTimes['deleted'])->delete();
        }
        return true;
        // END Edit Work Times Over Weeks
    }

    private function syncRelationModel($model, $columnName = 'id', $arrayValues = null)
    {
        $oldIds = $model->pluck($columnName)->toArray();
        $data['deleted'] = array_values(array_diff($oldIds, $arrayValues));
        $data['updated'] = array_values(array_intersect($oldIds, $arrayValues));
        return $data;
    }
}

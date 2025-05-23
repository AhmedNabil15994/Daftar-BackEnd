<?php

namespace Modules\DeliveryTime\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\DeliveryTime\Http\Requests\Dashboard\DeliveryTimeRequest;
use Modules\DeliveryTime\Transformers\Dashboard\DeliveryTimeResource;
use Modules\DeliveryTime\Repositories\Dashboard\DeliveryTimeRepository as DeliveryTime;

class OldDeliveryTimeController extends Controller
{

    function __construct(DeliveryTime $time)
    {
        $this->time = $time;
    }

    public function index()
    {
        return view('deliverytime::dashboard.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->time->QueryTable($request));

        $datatable['data'] = DeliveryTimeResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function create()
    {
        return view('deliverytime::dashboard.create');
    }

    public function store(DeliveryTimeRequest $request)
    {
        try {

            $create = $this->time->create($request);

            if ($create) {
                return Response()->json([true , __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('deliverytime::dashboard.show');
    }

    public function edit($id)
    {
        $time = $this->time->findById($id);

        return view('deliverytime::dashboard.edit',compact('time'));
    }

    public function update(DeliveryTimeRequest $request, $id)
    {
        try {

            $update = $this->time->update($request,$id);

            if ($update) {
                return Response()->json([true , __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {

            $delete = $this->time->delete($id);

            if ($delete) {
                return Response()->json([true , __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {

            $deleteSelected = $this->time->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);

        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

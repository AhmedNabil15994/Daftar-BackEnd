<?php

namespace Modules\Vendor\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Vendor\Http\Requests\Dashboard\DeliveryChargeRequest;
use Modules\Vendor\Transformers\Dashboard\VendorResource;
use Modules\Area\Transformers\Dashboard\StateResource;
use Modules\Vendor\Transformers\Dashboard\DeliveryChargeResource;
use Modules\Vendor\Repositories\Dashboard\VendorRepository as Vendor;
use Modules\Area\Repositories\Dashboard\StateRepository as State;
use Modules\Vendor\Repositories\Dashboard\DeliveryChargeRepository as DeliveryCharge;

class DeliveryChargeController extends Controller
{
    function __construct(DeliveryCharge $deliveryCharge,Vendor $vendor,State $state)
    {
        $this->vendor         = $vendor;
        $this->state          = $state;
        $this->deliveryCharge = $deliveryCharge;
    }

    public function index()
    {
        return view('vendor::dashboard.delivery-charges.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->state->QueryTable($request));

        $datatable['data'] = StateResource::collection($datatable['data']);

        return Response()->json($datatable);
    }

    public function edit($id)
    {
        $state = $this->state->findById($id);
        return view('vendor::dashboard.delivery-charges.edit',compact('state'));
    }

    public function update(Request $request, $stateId)
    {
        try {
            $update = $this->deliveryCharge->update($request,$stateId);

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
            $delete = $this->deliveryCharge->delete($id);

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
            $deleteSelected = $this->deliveryCharge->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true , __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false  , __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

<?php

namespace Modules\PopupAdds\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\PopupAdds\Http\Requests\Dashboard\PopupAddsRequest;
use Modules\PopupAdds\Transformers\Dashboard\PopupAddsResource;
use Modules\PopupAdds\Repositories\Dashboard\PopupAddsRepository as PopupAdds;

class PopupAddsController extends Controller
{
    protected $popupAdds;

    function __construct(PopupAdds $popupAdds)
    {
        $this->popupAdds = $popupAdds;
    }

    public function index()
    {
        return view('popup_adds::dashboard.index');
    }

    public function datatable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->popupAdds->QueryTable($request));
        $datatable['data'] = PopupAddsResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function create()
    {
        return view('popup_adds::dashboard.create');
    }

    public function store(PopupAddsRequest $request)
    {
        try {
            $create = $this->popupAdds->create($request);

            if ($create) {
                return Response()->json([true, __('apps::dashboard.general.message_create_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function show($id)
    {
        return view('popup_adds::dashboard.show');
    }

    public function edit($id)
    {
        $popupAdds = $this->popupAdds->findById($id);
        return view('popup_adds::dashboard.edit', compact('popupAdds'));
    }

    public function update(PopupAddsRequest $request, $id)
    {
        try {
            $update = $this->popupAdds->update($request, $id);

            if ($update) {
                return Response()->json([true, __('apps::dashboard.general.message_update_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function destroy($id)
    {
        try {
            $delete = $this->popupAdds->delete($id);

            if ($delete) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }

    public function deletes(Request $request)
    {
        try {
            $deleteSelected = $this->popupAdds->deleteSelected($request);

            if ($deleteSelected) {
                return Response()->json([true, __('apps::dashboard.general.message_delete_success')]);
            }

            return Response()->json([false, __('apps::dashboard.general.message_error')]);
        } catch (\PDOException $e) {
            return Response()->json([false, $e->errorInfo[2]]);
        }
    }
}

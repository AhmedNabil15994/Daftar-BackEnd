<?php

namespace Modules\Setting\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Http\Requests\Dashboard\SettingRequest;
use Modules\Setting\Repositories\Dashboard\SettingRepository as Setting;

class SettingController extends Controller
{
    protected $setting;

    function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('setting::dashboard.index');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     */
    public function update(SettingRequest $request)
    {
        $this->setting->set($request);
        return redirect()->back()->with(['msg' => __('setting::dashboard.settings.messages.settings_updated_successfully'), 'alert' => 'success']);
    }

}

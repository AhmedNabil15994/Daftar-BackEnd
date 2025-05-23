<?php

namespace Modules\Apps\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class VendorController extends Controller
{
    public function index()
    {
        return view('apps::vendor.index');
    }
}

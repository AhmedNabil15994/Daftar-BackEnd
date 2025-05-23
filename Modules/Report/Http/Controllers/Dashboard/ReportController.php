<?php

namespace Modules\Report\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Traits\DataTable;
use Modules\Report\Repositories\Dashboard\ReportRepository as Repo;

class ReportController extends Controller
{
    protected $repo;

    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
    }

    public function productsReports()
    {
        return view('catalog::dashboard.products.reports');
    }

    public function ordersReports()
    {
        return view('order::dashboard.orders.reports');
    }

    public function reports()
    {
        return view('report::dashboard.index');
    }

    public function productsSaleDataTable(Request $request)
    {
        $datatable = DataTable::drawTable($request, $this->repo->productSales($request));
        return Response()->json($datatable);
    }

    public function getProductsSalesReports()
    {
        return view('report::dashboard.order-products');
    }
}

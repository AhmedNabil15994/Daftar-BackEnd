<?php

namespace Modules\Vendor\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Order\Repositories\FrontEnd\OrderRepository as Order;
use Modules\Catalog\Repositories\FrontEnd\BrandRepository as Brand;
use Modules\Vendor\Repositories\FrontEnd\VendorRepository as Vendor;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Modules\Catalog\Repositories\FrontEnd\CategoryRepository as Category;

class VendorController extends Controller
{

    function __construct(Vendor $vendor,Product $product,Category $category,Brand $brand,Order $order)
    {
        $this->product  = $product;
        $this->vendor   = $vendor;
        $this->category = $category;
        $this->brand    = $brand;
        $this->order    = $order;
    }

    public function index(Request $request,$slug)
    {
        $vendor       = $this->vendor->findBySlug($slug);

        if(!$vendor)
            abort(404);

        $sorting = $request['sorting'] ? $request['sorting'] : 'id';

        $productsList = $this->product->prouctsOfVendorPaginate($vendor,$sorting);
        $categories   = $this->category->mainCategoriesOfVendorProducts($vendor);
        $brands       = $this->brand->getAllActiveByVendor($vendor);
        $rangePrice   = $this->product->rangePrice($vendor);

        if ($this->vendor->checkRouteLocale($vendor,$slug)){

          return view('vendor::frontend.vendors.index',
                 compact('vendor','productsList','categories','brands','rangePrice')
               );

        }

        return redirect()->route('frontend.vendors.index', $vendor->translate(locale())->slug);
    }

    public function rating(Request $request,$id)
    {
        $order  = $this->order->findById($id);
        $vendor = $order->vendor;

        if(!$vendor)
            abort(404);

        return view('vendor::frontend.vendors.rating',compact('vendor','order'));
    }

    public function saveRating(Request $request,$id)
    {
        $order  = $this->order->findById($id);
        $rating = $this->vendor->saveRating($order,$request);

        return redirect()->back()->with(['status'=>__('apps::frontend.contact_us.alerts.rate_message')]);
    }
}

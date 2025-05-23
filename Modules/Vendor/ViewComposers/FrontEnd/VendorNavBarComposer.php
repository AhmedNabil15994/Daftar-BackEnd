<?php

namespace Modules\Vendor\ViewComposers\FrontEnd;

use Modules\Vendor\Repositories\FrontEnd\VendorRepository as Vendor;
use Modules\Vendor\Transformers\FrontEnd\VendorResource;
use Illuminate\View\View;
use Cache;

class VendorNavBarComposer
{
    public $vendors = [];

    public function __construct(Vendor $vendor)
    {
        $this->vendors =  $vendor->getAllWithoutSection();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('navVendors' , $this->vendors);
    }
}

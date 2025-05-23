<?php

namespace Modules\Vendor\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Vendor\Transformers\FrontEnd\SectionResource;
use Modules\Vendor\Repositories\FrontEnd\VendorRepository as Vendor;
use Modules\Vendor\Repositories\FrontEnd\SectionRepository as Section;

class SectionController extends Controller
{

    function __construct(Section $section,Vendor $vendor)
    {
        $this->vendor  = $vendor;
        $this->section = $section;
    }

    public function index($slug)
    {
        $section    = $this->section->findBySlug($slug);

        if(!$section)
            abort(404);

        $vendors    = $this->vendor->getAllActiveBySectionPaginate($section);

        if ($this->section->checkRouteLocale($section,$slug))
            return view('vendor::frontend.sections.index',compact('section','vendors'));

        return redirect()->route('frontend.sections.index', $section->translate(locale())->slug);
    }
}

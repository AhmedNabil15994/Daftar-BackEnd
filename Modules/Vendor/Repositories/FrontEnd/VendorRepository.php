<?php

namespace Modules\Vendor\Repositories\FrontEnd;

use Modules\Vendor\Entities\Vendor;
use Hash;
use DB;

class VendorRepository
{

    function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    /*
    * Frontend Queries
    */
    public function getVendorProdutsSearh($data, $text)
    {
        $vendorIds = [];

        foreach ($data as $key => $value) {
            $vendorIds[] = $key;
        }

        $res[] = $this->vendor->whereIn('id', $vendorIds)->with([
            'products' => function ($query) use ($text) {
                $query->with([
                    'newArrival' => function ($query) {
                        $query->active()->unexpired()->started();
                    },
                    'offer' => function ($query) {
                        $query->active()->unexpired()->started();
                    },
                    'images',
                ]);
                $query->active()->whereHas('translations', function ($query) use ($text) {
                    $query->where('description', 'like', '%' . $text . '%');
                    $query->orWhere('title', 'like', '%' . $text . '%');
                    $query->orWhere('slug', 'like', '%' . $text . '%');
                });
            }
        ])->whereHas('subbscription', function ($query) {

            $query->active()->unexpired()->started();

        })->orderBy('sorting', 'ASC')->paginate(12);

        return $res ? $res[0] : $res;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $vendors = $this->vendor->active()->orderBy('sorting', 'ASC')->get();
        return $vendors;
    }


    public function saveRating($order, $request)
    {
        $rate = $order->rating()->create([
            'vendor_id' => $order->vendor_id,
            'order_id' => $order->id,
            'rate' => $request->rate,
        ]);

        return $rate;
    }


    public function getAllActiveBySection($section)
    {
        $vendors = $this->vendor->active()
            ->whereHas('sections', function ($query) use ($section) {

                $query->where('section_id', $section->id);

            })->whereHas('subbscription', function ($query) {

                $query->active()->unexpired()->started();

            })->whereHas('products', function ($query) {

                $query->active();

            })->orderBy('sorting', 'ASC')->take(12)->get();

        return $vendors;
    }

    public function getAllWithoutSection()
    {
        $vendors = $this->vendor->active()->doesntHave('sections')
            ->whereHas('subbscription', function ($query) {

                $query->active()->unexpired()->started();

            })->whereHas('products', function ($query) {

                $query->active();

            })->orderBy('sorting', 'ASC')->take(12)->get();

        return $vendors;
    }

    public function getAllActiveBySectionPaginate($section)
    {
        $vendors = $this->vendor->active()
            ->whereHas('sections', function ($query) use ($section) {

                $query->where('section_id', $section->id);

            })->whereHas('subbscription', function ($query) {

                $query->active()->unexpired()->started();

            })->whereHas('products', function ($query) {

                $query->active();

            })->orderBy('sorting', 'ASC')->paginate(24);

        return $vendors;
    }

    public function findById($id)
    {
        return $this->vendor->find($id);
    }

    public function findBySlug($slug)
    {
        $vendor = $this->vendor
            ->whereHas('subbscription', function ($query) {

                $query->active()->unexpired()->started();

            })->whereHas('products', function ($query) {

                $query->active();

            })->whereTranslation('slug', $slug)->first();

        return $vendor;
    }

    public function checkRouteLocale($model, $slug)
    {
        if ($model->translate()->where('slug', $slug)->first()->locale != locale())
            return false;

        return true;
    }

}

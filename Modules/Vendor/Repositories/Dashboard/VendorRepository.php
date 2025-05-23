<?php

namespace Modules\Vendor\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Modules\Core\Traits\CoreTrait;
use Modules\Vendor\Entities\Payment;
use Modules\Vendor\Entities\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class VendorRepository
{
    use CoreTrait;

    protected $vendor;
    protected $payment;

    function __construct(Vendor $vendor, Payment $payment)
    {
        $this->vendor = $vendor;
        $this->payment = $payment;
    }

    public function countVendors()
    {
        $vendors = $this->vendor->count();
        return $vendors;
    }

    public function countSubscriptionsVendors()
    {
        $vendors = $this->vendor->whereHas('subbscription', function ($query) {

            $query->active()->unexpired()->started();

        })->count();

        return $vendors;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $vendors = $this->vendor->orderBy($order, $sort)->get();
        return $vendors;
    }

    public function findById($id)
    {
        $vendor = $this->vendor->withDeleted()->find($id);
        return $vendor;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $data = [
                'fixed_commission' => $request->fixed_commission,
                'commission' => $request->commission,
                'order_limit' => $request->order_limit,
                'fixed_delivery' => $request->fixed_delivery,
//                'image' => path_without_domain($request->image),
                'status' => $request->status ? 1 : 0,
                'is_trusted' => $request->is_trusted ? 1 : 0,
            ];

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage(public_path(config('core.config.vendor_img_path')), $request->image);
                $data['image'] = config('core.config.vendor_img_path') . '/' . $imgName;
            } else {
                $data['image'] = url(config('setting.logo'));
            }

            $vendor = $this->vendor->create($data);

            $vendor->sellers()->sync($request->seller_id);
            $vendor->sections()->sync($request->section_id);
            $vendor->payments()->sync($request->payment_id);

            $this->translateTable($vendor, $request);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        $vendor = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($vendor) : null;

        try {

            $data = [
                'fixed_commission' => $request->fixed_commission,
                'commission' => $request->commission,
                'order_limit' => $request->order_limit,
                'fixed_delivery' => $request->fixed_delivery,
//                'image' => $request->image ? path_without_domain($request->image) : $vendor->image,
                'status' => $request->status ? 1 : 0,
                'is_trusted' => $request->is_trusted ? 1 : 0,
            ];

            if ($request->image) {
                if (!empty($vendor->image) && !in_array($vendor->image, config('core.config.special_images'))) {
                    File::delete($vendor->image); ### Delete old image
                }
                $imgName = $this->uploadImage(public_path(config('core.config.vendor_img_path')), $request->image);
                $data['image'] = config('core.config.vendor_img_path') . '/' . $imgName;
            } else {
                $data['image'] = $vendor->image;
            }

            $vendor->update($data);

            $vendor->sellers()->sync($request->seller_id);
            $vendor->sections()->sync($request->section_id);
            $vendor->payments()->sync($request->payment_id);

            $this->translateTable($vendor, $request);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function sorting($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['vendors'] as $key => $value) {
                $key++;
                $model = $this->vendor->find($value);
                if ($model) {
                    $model->update([
                        'sorting' => $key,
                    ]);
                }
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function restoreSoftDelete($model)
    {
        $model->restore();
    }

    public function translateTable($model, $request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title = $value;
            $model->translateOrNew($locale)->slug = slugfy($value);
            $model->translateOrNew($locale)->description = $request['description'][$locale];
            $model->translateOrNew($locale)->seo_description = $request['seo_description'][$locale];
            $model->translateOrNew($locale)->seo_keywords = $request['seo_keywords'][$locale];
        }

        $model->save();
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {

            $model = $this->findById($id);
            if ($model && !empty($model->image) && !in_array($model->image, config('core.config.special_images'))) {
                File::delete($model->image); ### Delete old image
            }

            if ($model->trashed()):
                $model->forceDelete();
            else:
                $model->delete();
            endif;

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function deleteSelected($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['ids'] as $id) {
                $model = $this->delete($id);
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function QueryTable($request)
    {
        $query = $this->vendor->with(['translations']);

        $query->where(function ($query) use ($request) {

            $query
                ->where('id', 'like', '%' . $request->input('search.value') . '%')
                ->orWhere(function ($query) use ($request) {

                    $query->whereHas('translations', function ($query) use ($request) {

                        $query->where('description', 'like', '%' . $request->input('search.value') . '%');
                        $query->orWhere('title', 'like', '%' . $request->input('search.value') . '%');
                        $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');

                    });

                });

        });

        return $this->filterDataTable($query, $request);
    }

    public function filterDataTable($query, $request)
    {
        // Search Pages by Created Dates
        if (isset($request['req']['from']))
            $query->whereDate('created_at', '>=', $request['req']['from']);

        if (isset($request['req']['to']))
            $query->whereDate('created_at', '<=', $request['req']['to']);

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only')
            $query->onlyDeleted();

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with')
            $query->withDeleted();

        if (isset($request['req']['status']) && $request['req']['status'] == '1')
            $query->active();

        if (isset($request['req']['status']) && $request['req']['status'] == '0')
            $query->unactive();

        if (isset($request['req']['sections'])) {

            $query->whereHas('sections', function ($query) use ($request) {
                $query->where('section_id', $request['req']['sections']);
            });

        }

        return $query;
    }

    public function getPaymentsMethods()
    {
        return $this->payment->orderBy('id', 'asc')->get();
    }
}

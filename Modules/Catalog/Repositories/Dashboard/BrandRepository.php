<?php

namespace Modules\Catalog\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Modules\Catalog\Entities\Brand;
use Hash;
use DB;
use Modules\Core\Traits\CoreTrait;

class BrandRepository
{
    use CoreTrait;

    protected $brand;

    function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $brands = $this->brand->orderBy($order, $sort)->get();
        return $brands;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        return $this->brand->where('status', 1)->orderBy($order, $sort)->get();
    }

    public function findById($id)
    {
        $brand = $this->brand->withDeleted()->find($id);
        return $brand;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $data = [
//                'image'    => path_without_domain($request->image),
                'status' => $request->status ? 1 : 0,
            ];

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage(public_path(config('core.config.brand_img_path')), $request->image);
                $data['image'] = config('core.config.brand_img_path') . '/' . $imgName;
            } else {
                $data['image'] = url(config('setting.logo'));
            }

            $brand = $this->brand->create($data);

            $this->translateTable($brand, $request);

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

        $brand = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($brand) : null;

        try {

            $data = [
//                'image' => $request->image ? path_without_domain($request->image) : $brand->image,
                'status' => $request->status ? 1 : 0,
            ];

            if ($request->image) {
                if (!empty($brand->image) && !in_array($brand->image, config('core.config.special_images'))) {
                    File::delete($brand->image); ### Delete old image
                }
                $imgName = $this->uploadImage(public_path(config('core.config.brand_img_path')), $request->image);
                $data['image'] = config('core.config.brand_img_path') . '/' . $imgName;
            } else {
                $data['image'] = $brand->image;
            }

            $brand->update($data);

            $this->translateTable($brand, $request);

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
        $query = $this->brand->with(['translations'])->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('translations', function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('slug', 'like', '%' . $request->input('search.value') . '%');
                });
            });
        });

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
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

        return $query;
    }

}

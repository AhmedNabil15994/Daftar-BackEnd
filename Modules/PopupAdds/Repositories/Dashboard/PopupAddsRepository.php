<?php

namespace Modules\PopupAdds\Repositories\Dashboard;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Catalog\Repositories\Dashboard\BrandRepository as Brand;
use Modules\Catalog\Repositories\Dashboard\CategoryRepository as Category;
use Modules\Catalog\Repositories\Dashboard\ProductRepository as Product;
use Modules\Core\Traits\CoreTrait;
use Modules\PopupAdds\Entities\PopupAdds;
use Modules\Vendor\Repositories\Dashboard\VendorRepository as Vendor;

class PopupAddsRepository
{
    use CoreTrait;

    protected $popupAdds;
    protected $product;
    protected $category;
    protected $vendor;
    protected $brand;

    public function __construct(PopupAdds $popupAdds, Product $product, Category $category, Vendor $vendor, Brand $brand)
    {
        $this->popupAdds = $popupAdds;
        $this->product = $product;
        $this->category = $category;
        $this->vendor = $vendor;
        $this->brand = $brand;
    }

    public function getAll()
    {
        return $this->popupAdds->get();
    }

    public function findById($id)
    {
        return $this->popupAdds->withDeleted()->find($id);
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = [
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
//                'image' => path_without_domain($request->image),
                'status' => $request->status ? 1 : 0,
                'sort' => $request->sort ?? 0,
            ];

            if ($request->popup_adds_type == 'external') {
                $data['link'] = $request->link;
            } elseif ($request->popup_adds_type == 'product') {
                $product = $this->product->findById($request->product_id);
                $data['popupable_id'] = $product ? $request->product_id : null;
                $data['popupable_type'] = $product ? get_class($product) : null;
            } elseif ($request->popup_adds_type == 'category') {
                $category = $this->category->findById($request->category_id);
                $data['popupable_id'] = $category ? $request->category_id : null;
                $data['popupable_type'] = $category ? get_class($category) : null;
            } elseif ($request->popup_adds_type == 'vendor') {
                $vendor = $this->vendor->findById($request->vendor_id);
                $data['popupable_id'] = $vendor ? $request->vendor_id : null;
                $data['popupable_type'] = $vendor ? get_class($vendor) : null;
            } elseif ($request->popup_adds_type == 'brand') {
                $brand = $this->brand->findById($request->brand_id);
                $data['popupable_id'] = $brand ? $request->brand_id : null;
                $data['popupable_type'] = $brand ? get_class($brand) : null;
            } else {
                $data['popupable_id'] = null;
                $data['popupable_type'] = null;
            }

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage(public_path(config('core.config.popup_ads_img_path')), $request->image);
                $data['image'] = config('core.config.popup_ads_img_path') . '/' . $imgName;
            } else {
                $data['image'] = url(config('setting.logo'));
            }

            $popupAdds = $this->popupAdds->create($data);
            $this->translateTable($popupAdds, $request);

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

        $popupAdds = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelete($popupAdds) : null;

        try {
            $data = [
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'image' => $request->image ? path_without_domain($request->image) : $popupAdds->image,
                'status' => $request->status ? 1 : 0,
                'sort' => $request->sort ?? 0,
            ];

            if ($request->popup_adds_type == 'external') {
                $data['link'] = $request->link;
                $data['popupable_id'] = null;
                $data['popupable_type'] = null;
            } elseif ($request->popup_adds_type == 'product') {
                $product = $this->product->findById($request->product_id);
                $data['link'] = null;
                $data['popupable_id'] = $product ? $request->product_id : null;
                $data['popupable_type'] = $product ? get_class($product) : null;
            } elseif ($request->popup_adds_type == 'category') {
                $category = $this->category->findById($request->category_id);
                $data['link'] = null;
                $data['popupable_id'] = $category ? $request->category_id : null;
                $data['popupable_type'] = $category ? get_class($category) : null;
            } elseif ($request->popup_adds_type == 'vendor') {
                $vendor = $this->vendor->findById($request->vendor_id);
                $data['link'] = null;
                $data['popupable_id'] = $vendor ? $request->vendor_id : null;
                $data['popupable_type'] = $vendor ? get_class($vendor) : null;
            } elseif ($request->popup_adds_type == 'brand') {
                $brand = $this->brand->findById($request->brand_id);
                $data['link'] = null;
                $data['popupable_id'] = $brand ? $request->brand_id : null;
                $data['popupable_type'] = $brand ? get_class($brand) : null;
            } else {
                $data['link'] = null;
                $data['popupable_id'] = null;
                $data['popupable_type'] = null;
            }

            if ($request->image) {
                if (!empty($popupAdds->image) && !in_array($popupAdds->image, config('core.config.special_images'))) {
                    File::delete($popupAdds->image); ### Delete old image
                }
                $imgName = $this->uploadImage(public_path(config('core.config.popup_ads_img_path')), $request->image);
                $data['image'] = config('core.config.popup_ads_img_path') . '/' . $imgName;
            } else {
                $data['image'] = $popupAdds->image;
            }

            $popupAdds->update($data);
            $this->translateTable($popupAdds, $request);

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

    public function translateTable($model, $request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title = $value;
            if (!is_null($request['short_description'][$locale])) {
                $model->translateOrNew($locale)->short_description = $request['short_description'][$locale];
            }

        }
        $model->save();
    }

    public function QueryTable($request)
    {
        $query = $this->popupAdds;

        $query = $this->filterDataTable($query, $request);

        return $query;
    }

    public function filterDataTable($query, $request)
    {
        // SEARCHING INPUT DATATABLE
        if ($request->input('search.value') != null) {

            $query = $query->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search.value') . '%');

                /*$query->orWhereHasMorph('popupable', [
            \Modules\Catalog\Entities\Product::class,
            \Modules\Catalog\Entities\Category::class,
            ], function ($query) use ($request) {
            $query->whereHas('popupAdds', function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->input('search.value') . '%');
            });
            });*/

            });

        }

        // FILTER
        if (isset($request['req']['from']) && $request['req']['from'] != '') {
            $query->whereDate('created_at', '>=', $request['req']['from']);
        }

        if (isset($request['req']['to']) && $request['req']['to'] != '') {
            $query->whereDate('created_at', '<=', $request['req']['to']);
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'only') {
            $query->onlyDeleted();
        }

        if (isset($request['req']['deleted']) && $request['req']['deleted'] == 'with') {
            $query->withDeleted();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '1') {
            $query->active();
        }

        if (isset($request['req']['status']) && $request['req']['status'] == '0') {
            $query->unactive();
        }

        return $query;
    }

}

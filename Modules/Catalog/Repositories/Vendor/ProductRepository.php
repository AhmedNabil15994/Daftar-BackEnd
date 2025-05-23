<?php

namespace Modules\Catalog\Repositories\Vendor;

use Modules\Catalog\Entities\Product;
use Illuminate\Support\Facades\DB;
use Image;
use Modules\Core\Traits\CoreTrait;
use Modules\Core\Traits\SyncRelationModel;

class ProductRepository
{
    use SyncRelationModel, CoreTrait;

    protected $product;

    function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $products = $this->produc->whereHas('vendor', function ($query) {
            $query->whereHas('sellers', function ($q) {
                $q->where('seller_id', auth()->user()->id);
            });
        })->orderBy($order, $sort)->get();

        return $products;
    }

    public function findById($id)
    {
        $product = $this->product->whereHas('vendor', function ($query) {
            $query->whereHas('sellers', function ($q) {
                $q->where('seller_id', auth()->user()->id);
            });
        })->withDeleted()->find($id);

        return $product;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            $image = 'storage/photos/shares/5e300ffd16038.png';

            if ($request->file('image')) {
                $image = $this->uploadImage(public_path(config('core.config.product_img_path')), $request->image);
            }

            $product = $this->product->create([
                //            'image' => path_without_domain($request->image),
                'image' => $image,
                'status' => $request->status ? 1 : 0,
                'price' => $request->price,
                'cost_price' => $request->cost_price,
                'qty' => $request->qty,
                'sku' => $request->sku,
                'vendor_id' => $request->vendor_id,
                'brand_id' => $request->brand_id,
            ]);

            $product->update([
                'sort' => $request->sort ?? $product->id,
            ]);

            $this->translateTable($product, $request);

            $product->categories()->sync(int_to_array($request->category_id));
            $this->productNewArrival($product, $request);
            $this->productImages($product, $request);
            $this->productOffer($product, $request);
            $this->productVariants($product, $request);

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

        $product = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($product) : null;

        //        dd($product->images()->whereIn('image', $request->images_old)->pluck('id')->toArray());

        $image = $product->image;
        if ($request->image) {
            $image = $this->uploadImage(public_path(config('core.config.product_img_path')), $request->image);
        }

        try {

            $product->update([
                //                'image' => $request->image ? path_without_domain($request->image) : $product->image,
                'image' => $image,
                'status' => $request->status ? 1 : 0,
                'price' => $request->price,
                'cost_price' => $request->cost_price,
                'qty' => $request->qty,
                'sku' => $request->sku,
                'vendor_id' => $request->vendor_id,
                'brand_id' => $request->brand_id,
                'sort' => $request->sort ?? $product->id,
            ]);

            $this->translateTable($product, $request);

            $product->categories()->sync(int_to_array($request->category_id));
            $this->productNewArrival($product, $request);
            $this->productImages($product, $request);
            $this->productOffer($product, $request);
            $this->productVariants($product, $request);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function productImages($model, $request)
    {
        $imagesIds = $model->images->pluck('id')->toArray() ?? [];
        $oldIds = $model->images->whereIn('image', $request->images_old)->pluck('id')->toArray() ?? [];
        $deletedIds = array_values(array_diff($imagesIds, $oldIds));
        $model->images()->whereIn('id', $deletedIds ?? [])->delete();

        if ($request['images']) {
            foreach ($request['images'] as $value) {
                if (!is_null($value)) {
                    $image = $this->uploadProductImages($value);
                    $model->images()->create([
                        //                        'image' => path_without_domain($value),
                        'image' => $image,
                    ]);
                }
            }
        }
    }

    public function productVariants($model, $request)
    {
        $data = [];
        if (isset($request['removed_variants'])) {
            $model->variants()->whereIn('id', int_to_array($request['removed_variants']))->delete();
        } elseif (isset($request['option_values_id'])) {
            return $this->addVariantsValues($model, $request);
        }
    }

    public function addVariantsValues($model, $request)
    {
        foreach ($request['option_values_id'] as $key => $value) {

            if (isset($request['v_images'][$key]) || isset($request['variation_sku'][$key])) {
                $image = $model->image;
                if ($request->file('v_images') && isset($request['v_images'][$key])) {
                    $image = $this->uploadProductImages($request['v_images'][$key]);
                }

                $variant = $model->variants()->create([
                    'sku' => $request['variation_sku'][$key],
                    'price' => $request['variation_price'][$key],
                    'status' => $request['variation_status'][$key],
                    'qty' => $request['variation_qty'][$key],
                    'image' => $image,
                ]);

                foreach ($value as $key2 => $value2) {
                    $variant->productValues()->create([
                        'option_value_id' => $value2,
                        'product_id' => $model['id'],
                    ]);
                }
            }
        }

        return true;
    }

    public function productOffer($model, $request)
    {
        if (isset($request['offer_status']) && $request['offer_status'] == 'on') {

            $model->offer()->updateOrCreate(
                ['product_id' => $model->id],
                [
                    'status' => ($request['offer_status'] == 'on') ? true : false,
                    'offer_price' => $request['offer_price'] ? $request['offer_price'] : $model->offer->offer_price,
                    'start_at' => $request['start_at'] ? $request['start_at'] : $model->offer->start_at,
                    'end_at' => $request['end_at'] ? $request['end_at'] : $model->offer->end_at,
                ]
            );
        }
    }

    public function productNewArrival($model, $request)
    {
        if (isset($request['arrival_status']) && $request['arrival_status'] == 'on') {

            $model->newArrival()->updateOrCreate(
                ['product_id' => $model->id],
                [
                    'status' => ($request['arrival_status'] == 'on') ? true : false,
                    'start_at' => $request['arrival_start_at'] ? $request['arrival_start_at'] : $model->newArrival->start_at,
                    'end_at' => $request['arrival_end_at'] ? $request['arrival_end_at'] : $model->newArrival->end_at,
                ]
            );
        }
    }

    public function restoreSoftDelte($model)
    {
        $model->restore();
    }

    public function translateTable($model, $request)
    {
        foreach ($request['title'] as $locale => $value) {
            $model->translateOrNew($locale)->title = $value;
            // $model->translateOrNew($locale)->slug            = slugfy($value);
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

            if ($model->trashed()) :
                $model->forceDelete();
            else :
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
        $query = $this->product->whereHas('vendor', function ($query) {
            $query->whereHas('sellers', function ($q) {
                $q->where('seller_id', auth()->user()->id);
            });
        })->with(['translations'])->where(function ($query) use ($request) {

            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere('sku', 'like', '%' . $request->input('search.value') . '%');
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
        // Search Categories by Created Dates
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

    public function uploadProductImages($image)
    {
        $filename = md5(rand() * time()) . '.' . $image->getClientOriginalExtension();
        $newPath = config('core.config.product_img_path') . '/' . $filename;
        $img = Image::make($image->getRealPath());
        $img->save($newPath);
        return $newPath;
    }
}

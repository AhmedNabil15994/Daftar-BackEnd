<?php

namespace Modules\Catalog\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Modules\Core\Traits\CoreTrait;
use Modules\Core\Traits\SyncRelationModel;
use Modules\Catalog\Entities\Product;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Modules\Variation\Entities\ProductVariant;

class ProductRepository
{
    use SyncRelationModel, CoreTrait;

    protected $product;
    protected $variantProduct;

    function __construct(Product $product, ProductVariant $variantProduct)
    {
        $this->product = $product;
        $this->variantProduct = $variantProduct;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $products = $this->product->orderBy($order, $sort)->get();
        return $products;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $products = $this->product->active()->orderBy($order, $sort)->get();
        return $products;
    }

    public function findById($id)
    {
        return $this->product->withDeleted()->find($id);
    }

    public function findActiveById($id)
    {
        return $this->product->active()->find($id);
    }

    public function findActiveVariantProductById($id)
    {
        return $this->variantProduct->with('product')->active()->find($id);
    }

    public function outOfStockList()
    {
        $product = $this->product->active()->whereHas('vendor', function ($query) {
            $query->active();
            $query->whereHas('subbscription', function ($q) {
                $q->active()->unexpired()->started();
            });
            $query->whereHas('sections', function ($q) {
                $q->active();
            });
        })->where('qty', '<=', 0)->get();

        return $product;
    }

    public function alertOutOfStockList()
    {
        $product = $this->product->active()->whereHas('vendor', function ($query) {
            $query->active();
            $query->whereHas('subbscription', function ($q) {
                $q->active()->unexpired()->started();
            });
            $query->whereHas('sections', function ($q) {
                $q->active();
            });
        })->where('qty', '=', config('setting.store.alert_stock'))->get();

        return $product;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {

            /*$image = 'storage/photos/shares/5e300ffd16038.png';
            if ($request->file('image')) {
                $image = $this->uploadProductImages($request->image);
            }*/

            $data = [
                'status' => $request->status ? 1 : 0,
                'most_popular' => $request->most_popular ? 1 : 0,
                'new_arrival' => $request->new_arrival ? 1 : 0,
                'price' => $request->price,
                'cost_price' => $request->cost_price,
                'qty' => $request->qty,
                'sku' => $request->sku,
                'vendor_id' => $request->vendor_id,
                'brand_id' => $request->brand_id,
            ];

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage(public_path(config('core.config.product_img_path')), $request->image);
                $data['image'] = config('core.config.product_img_path') . '/' . $imgName;
            } else {
                $data['image'] = url(config('setting.logo'));
            }

            $product = $this->product->create($data);

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

        /*$image = $product->image;
        if ($request->image) {
            $image = $this->uploadProductImages($request->image);
        }*/

        try {
            $data = [
                'status' => $request->status ? 1 : 0,
                'most_popular' => $request->most_popular ? 1 : 0,
                'new_arrival' => $request->new_arrival ? 1 : 0,
                'price' => $request->price,
                'cost_price' => $request->cost_price,
                'qty' => $request->qty,
                'sku' => $request->sku,
                'vendor_id' => $request->vendor_id,
                'brand_id' => $request->brand_id,
                'sort' => $request->sort ?? $product->id,
            ];

            if ($request->image) {
                if (!empty($product->image) && !in_array($product->image, config('core.config.special_images'))) {
                    File::delete($product->image); ### Delete old image
                }
                $imgName = $this->uploadImage(public_path(config('core.config.product_img_path')), $request->image);
                $data['image'] = config('core.config.product_img_path') . '/' . $imgName;
            } else {
                $data['image'] = $product->image;
            }

            $product->update($data);

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
                        'image' => $image,
                    ]);
                }
            }
        }

        /*if ($request['images_old']) {
            foreach ($request['images_old'] as $value) {
                if (!is_null($value)) {
                    $model->images()->create([
                        'image' => $value,
                    ]);
                }
            }
        }*/
    }

    public function productVariants($model, $request)
    {
        $oldValues = isset($request['variants']['_old']) ? $request['variants']['_old'] : [];

        $sync = $this->syncRelation($model, 'variants', $oldValues);
        if ($sync['deleted']) {
            $model->variants()->whereIn('id', $sync['deleted'])->delete();
        }

        if ($sync['updated']) {

            foreach ($sync['updated'] as $id) {
                foreach ($request['upateds_option_values_id'] as $key => $varianteId) {

                    if (isset($request['_v_images'][$id]) || isset($request['_variation_sku'][$id])) {
                        $image = $request['_v_images_hidden'][$id] ?? null;
                        if ($request->file('_v_images')) {
                            $image = isset($request['_v_images'][$id]) ? $this->uploadProductImages($request['_v_images'][$id]) : $image;
                        }
                        $model->variants()->find($id)->update([
                            'sku' => $request['_variation_sku'][$id],
                            'price' => $request['_variation_price'][$id],
                            'status' => $request['_variation_status'][$id],
                            'qty' => $request['_variation_qty'][$id],
                            'image' => $image
                        ]);
                    }
                }
            }
        }

        if ($request['option_values_id']) {

            $key = 0;
            foreach ($request['option_values_id'] as $index => $value) {

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
                        'image' => $image
                    ]);
                    $key++;

                    foreach ($value as $key2 => $value2) {
                        $variant->productValues()->create([
                            'option_value_id' => $value2,
                            'product_id' => $model['id'],
                        ]);
                    }
                }
            }
        }
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
        } else {
            if ($model->offer) {
                $model->offer()->delete();
            }
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
        } else {
            if ($model->newArrival) {
                $model->newArrival()->delete();
            }
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
            if ($model && !empty($model->image) && !in_array($model->image, config('core.config.special_images'))) {
                File::delete($model->image); ### Delete old image
            }

            if ($model) {
                if ($model->trashed()) :
                    $model->forceDelete();
                else :
                    $model->delete();
                endif;
            }

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
        $query = $this->product->with(['translations', 'categories', 'vendor'])
            ->where(function ($query) use ($request) {
                $query->where('id', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('sku', 'like', '%' . $request->input('search.value') . '%');
                $query->orWhere('price', 'like', '%' . $request->input('search.value') . '%');
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

        if (isset($request['req']['vendor']))
            $query->where('vendor_id', $request['req']['vendor']);

        if (isset($request['req']['vendor']))
            $query->where('vendor_id', $request['req']['vendor']);

        if (isset($request['req']['categories'])) {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request['req']['categories']);
            });
        }

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

<?php

namespace Modules\Catalog\Repositories\Dashboard;

use Illuminate\Support\Facades\File;
use Modules\Catalog\Entities\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Modules\Core\Traits\CoreTrait;

class CategoryRepository
{
    use CoreTrait;

    protected $category;

    function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $categories = $this->category->orderBy($order, $sort)->get();
        return $categories;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $categories = $this->category->where('status', 1)->orderBy($order, $sort)->get();
        return $categories;
    }

    public function mainCategories($order = 'id', $sort = 'desc')
    {
        $categories = $this->category->mainCategories()->orderBy($order, $sort)->get();
        return $categories;
    }

    public function findById($id)
    {
        $category = $this->category->withDeleted()->find($id);
        return $category;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = [
//                'image' => path_without_domain($request->image),
                'status' => $request->status ? 1 : 0,
                'is_navbar' => $request->is_navbar ? 1 : 0,
                'category_id' => ($request->category_id != "null") ? $request->category_id : null,
            ];

            if (!is_null($request->image)) {
                $imgName = $this->uploadImage(public_path(config('core.config.category_img_path')), $request->image);
                $data['image'] = config('core.config.category_img_path') . '/' . $imgName;
            } else {
                $data['image'] = url(config('setting.logo'));
            }

            $category = $this->category->create($data);

            $this->translateTable($category, $request);

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

        $category = $this->findById($id);
        $restore = $request->restore ? $this->restoreSoftDelte($category) : null;

        try {
            $data = [
//                'image' => $request->image ? path_without_domain($request->image) : $category->image,
                'status' => $request->status ? 1 : 0,
                'is_navbar' => $request->is_navbar ? 1 : 0,
                'category_id' => ($request->category_id != "null") ? $request->category_id : null,
            ];

            if ($request->image) {
                if (!empty($category->image) && !in_array($category->image, config('core.config.special_images'))) {
                    File::delete($category->image); ### Delete old image
                }
                $imgName = $this->uploadImage(public_path(config('core.config.category_img_path')), $request->image);
                $data['image'] = config('core.config.category_img_path') . '/' . $imgName;
            } else {
                $data['image'] = $category->image;
            }

            $category->update($data);

            $this->translateTable($category, $request);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
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
            $model->translateOrNew($locale)->slug = slugfy($value);
            $model->translateOrNew($locale)->seo_description = $request['seo_description'][$locale];
            $model->translateOrNew($locale)->seo_keywords = $request['seo_keywords'][$locale];
        }

        $model->save();
    }

    public function sorting($request)
    {
        DB::beginTransaction();

        try {

            foreach ($request['categories'] as $key => $value) {
                $key++;
                $model = $this->category->find($value);
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
        $query = $this->category->with(['translations'])->where(function ($query) use ($request) {
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

}

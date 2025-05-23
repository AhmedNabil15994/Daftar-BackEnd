<?php

namespace Modules\Advertising\Repositories\Api;

use Modules\Advertising\Entities\Advertising;
use Modules\Advertising\Entities\AdvertisingGroup;

class AdvertisingRepository
{
    protected $advertising;
    protected $adGroup;

    function __construct(Advertising $advertising, AdvertisingGroup $adGroup)
    {
        $this->advertising = $advertising;
        $this->adGroup = $adGroup;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        return $this->advertising->whereNull('deleted_at')->active()->unexpired()->started()
            ->whereHas('advertGroup', function ($query) {
                $query->active();
                $query->whereNull('deleted_at');
            })
            ->inRandomOrder()->take(5)->get();
    }

    public function getAdvertGroups($request)
    {
        $groups = $this->adGroup->whereNull('deleted_at')->active()->with(['adverts' => function ($query) {
            $query->whereNull('deleted_at')->active()->unexpired()->started()->orderBy('sort', 'asc');
        }]);
        if ($request->position != 'all') {
            $groups = $groups->where('position', $request->position);
        }
        return $groups->orderBy('sort', 'asc')->get();
    }

    public function getRandomAdvert($request)
    {
        return $this->advertising->whereNull('deleted_at')->active()->unexpired()->started()
            ->whereHas('advertGroup', function ($query) {
                $query->active();
                $query->whereNull('deleted_at');
            })
            ->inRandomOrder()->first();
    }

}

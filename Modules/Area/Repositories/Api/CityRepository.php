<?php

namespace Modules\Area\Repositories\Api;

use Modules\Area\Entities\City;
use Hash;
use DB;

class CityRepository
{

    function __construct(City $city)
    {
        $this->city   = $city;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        return $cities = $this->city->with('states')->active()->orderBy($order, $sort)->get();
    }

    public function findById($id)
    {
        $city = $this->city->active()->where('id',$id)->first();
        return $city;
    }
}

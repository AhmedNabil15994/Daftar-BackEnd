<?php

namespace Modules\Area\Repositories\FrontEnd;

use Modules\Area\Entities\State;
use Hash;
use DB;

class StateRepository
{

    function __construct(State $state)
    {
        $this->state   = $state;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $states = $this->state->orderBy($order, $sort)->get();
        return $states;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $states = $this->state->active()->orderBy($order, $sort)->get();
        return $states;
    }

    public function getAllByCityId($cityId)
    {
        $states = $this->state->where('city_id',$cityId)->get();
        return $states;
    }

}

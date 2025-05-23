<?php

namespace Modules\PopupAdds\Repositories\FrontEnd;

use Modules\PopupAdds\Entities\PopupAdds;

class PopupAddsRepository
{
    protected $popupAdd;

    function __construct(PopupAdds $popupAdd)
    {
        $this->popupAdd = $popupAdd;
    }

    public function getAllActive()
    {
        return $this->popupAdd->where('status', true)->sortAsc()->get();
    }

    public function getRandomAdvert($request = null)
    {
        return $this->popupAdd->active()->unexpired()->started()->inRandomOrder()->first();
    }

}

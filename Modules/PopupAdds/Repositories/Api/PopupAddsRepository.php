<?php

namespace Modules\PopupAdds\Repositories\Api;

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
        return $this->popupAdd->whereNull('deleted_at')->where('status', true)->sortAsc()->get();
    }

    public function getRandomAdvert($request)
    {
        return $this->popupAdd->whereNull('deleted_at')->active()->unexpired()->started()->inRandomOrder()->first();
    }

}

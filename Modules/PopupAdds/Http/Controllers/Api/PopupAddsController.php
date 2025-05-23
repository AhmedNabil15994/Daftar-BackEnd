<?php

namespace Modules\PopupAdds\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\PopupAdds\Transformers\Api\PopupAddsResource;
use Modules\PopupAdds\Repositories\Api\PopupAddsRepository as PopupAdds;

class PopupAddsController extends ApiController
{
    protected $popupAdd;

    function __construct(PopupAdds $popupAdd)
    {
        $this->popupAdd = $popupAdd;
    }

    public function list(Request $request)
    {
        $popupAdds = $this->popupAdd->getAllActive();
        return PopupAddsResource::collection($popupAdds);
    }

    public function getRandomAdvert(Request $request)
    {
        $advert = $this->popupAdd->getRandomAdvert($request);
        if ($advert)
            return $this->response(new PopupAddsResource($advert));
        else
            return $this->response(null);
    }

}

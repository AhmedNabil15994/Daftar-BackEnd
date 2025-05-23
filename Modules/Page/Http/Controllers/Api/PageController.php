<?php

namespace Modules\Page\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Page\Transformers\Api\PageResource;
use Modules\Page\Repositories\Api\PageRepository as Page;

class PageController extends ApiController
{
    function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function list(Request $request)
    {
        $pages =  $this->page->getAllActive($request);
        return PageResource::collection($pages);
    }
}

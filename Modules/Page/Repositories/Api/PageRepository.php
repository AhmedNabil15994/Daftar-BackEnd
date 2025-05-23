<?php

namespace Modules\Page\Repositories\Api;

use Modules\Page\Entities\Page;

class PageRepository
{
    function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function getAllActive()
    {
        $pages = $this->page->where('status',true)->get();

        return $pages;
    }
}

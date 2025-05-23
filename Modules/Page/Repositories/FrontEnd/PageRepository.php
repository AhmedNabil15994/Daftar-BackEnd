<?php

namespace Modules\Page\Repositories\FrontEnd;

use Modules\Page\Entities\Page;
use Hash;
use DB;

class PageRepository
{

    function __construct(Page $page)
    {
        $this->page   = $page;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $pages = $this->page->active()->orderBy($order, $sort)->get();
        return $pages;
    }

    public function findBySlug($slug)
    {
        $page = $this->page->whereTranslation('slug',$slug)->first();

        return $page;
    }

    public function checkRouteLocale($model,$slug)
    {
        if ($model->translate()->where('slug', $slug)->first()->locale != locale())
            return false;

        return true;
    }

}

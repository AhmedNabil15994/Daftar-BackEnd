<?php

namespace Modules\Catalog\ViewComposers\FrontEnd;

use Modules\Catalog\Repositories\FrontEnd\CategoryRepository as Category;
use Illuminate\View\View;
use Cache;

class CategoryComposer
{
    public function __construct(Category $category)
    {
        $this->navCategories     =  $category->getAllNavBar();
        $this->mainCategories    =  $category->mainCategories();
    }

    public function compose(View $view)
    {
        $view->with('navCategories' , $this->navCategories);
        $view->with('mainCategories' , $this->mainCategories);
    }
}

<?php

namespace Modules\Vendor\ViewComposers\FrontEnd;

use Modules\Vendor\Repositories\FrontEnd\SectionRepository as Section;
use Illuminate\View\View;
use Cache;

class SectionNavBarComposer
{
    public function __construct(Section $section)
    {
        $this->headerSections =  $section->headerSections();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('headerSections'    , $this->headerSections);
    }
}

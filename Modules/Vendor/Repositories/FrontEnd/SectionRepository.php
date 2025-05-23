<?php

namespace Modules\Vendor\Repositories\FrontEnd;

use Modules\Vendor\Entities\Section;
use Hash;
use DB;

class SectionRepository
{

    function __construct(Section $section)
    {
        $this->section   = $section;
    }

    /*
    * Frontend Queries
    */
    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $sections = $this->section->active()->orderBy($order, $sort)->get();
        return $sections;
    }

    public function headerSections()
    {
        $sections = $this->section
                    ->whereHas('vendors', function($query){
                        $query
                        ->active()
                        ->whereHas('subbscription', function($query){
                            $query->active()->unexpired()->started();
                            $query;
                        })
                        ->whereHas('products', function($query){
                            $query->active();
                        });
                    })->active()->inRandomOrder()->take(3)->get();

        return $sections;
    }

    public function getAllActiveWithVendors()
    {
        $sections = $this->section->with([
                      'vendors' => function ($query) {
                        $query->active()->whereHas('subbscription', function($query){

                            $query->active()->unexpired()->started();

                        });
                      },
                    ])
                    ->whereHas('vendors', function($query){
                        $query
                        ->active()
                        ->whereHas('subbscription', function($query){
                            $query->active()->unexpired()->started();
                            $query;
                        })
                        ->whereHas('products', function($query){
                            $query->active();
                        });
                    })->active()->inRandomOrder()->take(10)->get();

        return $sections;
    }

    public function findBySlug($slug)
    {
        $section = $this->section
                  ->whereHas('vendors', function($query){
                      $query
                      ->active()
                      ->whereHas('subbscription', function($query){
                          $query->active()->unexpired()->started();
                          $query;
                      })
                      ->whereHas('products', function($query){
                          $query->active();
                      });
                  })->whereTranslation('slug',$slug)->first();

        return $section;
    }

    public function checkRouteLocale($model,$slug)
    {
        if ($model->translate()->where('slug', $slug)->first()->locale != locale())
            return false;

        return true;
    }
}

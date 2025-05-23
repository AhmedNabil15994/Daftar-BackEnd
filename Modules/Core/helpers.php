<?php

use Modules\Variation\Entities\Option;
use Modules\Catalog\Entities\Category;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\Brand;

// Active Dashboard Menu
if (!function_exists('active_menu2')) {

    function active_menu2($route)
    {
        return (Route::currentRouteName() == $route) ? 'active' : '';
    }
}

// Active Dashboard Menu
if (!function_exists('active_menu')) {
    function active_menu($routeNames)
    {
        $routeNames = (array)$routeNames;
        foreach ($routeNames as $routeName) {
            return (strpos(Route::currentRouteName(), $routeName) == 0) ? '' : 'active';
        }
    }
}

// GET THE CURRENT LOCALE
if (!function_exists('locale')) {

    function locale()
    {
        return app()->getLocale();
    }
}

// GET THE CURRENT LOCALE
if (!function_exists('locale')) {

    function locale()
    {
        return app()->getLocale();
    }
}

// CHECK IF CURRENT LOCALE IS RTL
if (!function_exists('is_rtl')) {

    function is_rtl($locale = null)
    {
        $locale = ($locale == null) ? locale() : $locale;
        $rtlLocales = is_null(config('rtl_locales')) ? [] : config('rtl_locales');

        if (in_array($locale, $rtlLocales)) {
            return 'rtl';
        }

        return 'ltr';
    }
}


if (!function_exists('slugfy')) {
    /**
     * The Current dir
     *
     * @param string $locale
     */
    function slugfy($string, $separator = '-')
    {
        $url = trim($string);
        $url = strtolower($url);
        $url = preg_replace('|[^a-z-A-Z\p{Arabic}0-9 _]|iu', '', $url);
        $url = preg_replace('/\s+/', ' ', $url);
        $url = str_replace(' ', $separator, $url);

        return $url;
    }
}


if (!function_exists('path_without_domain')) {
    /**
     * Get Path Of File Without Domain URL
     *
     * @param string $locale
     */
    function path_without_domain($path)
    {
        $url = $path;
        $parts = explode("/", $url);
        array_shift($parts);
        array_shift($parts);
        array_shift($parts);
        $newurl = implode("/", $parts);

        return $newurl;
    }
}


if (!function_exists('int_to_array')) {
    /**
     * convert a comma separated string of numbers to an array
     *
     * @param string $integers
     */
    function int_to_array($integers)
    {
        return array_map("intval", explode(",", $integers));
    }
}


if (!function_exists('combinations')) {

    function combinations($arrays, $i = 0)
    {

        if (!isset($arrays[$i])) {
            return array();
        }

        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = combinations($arrays, $i + 1);

        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ?
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }

        return $result;
    }
}

if (!function_exists('htmlView')) {
    /**
     * Access the OrderStatus helper.
     */
    function htmlView($content)
    {
        if (locale() == 'ar') {
            $css = url('frontend/ar/css/bootstrap-ar.min.css');
            $js = url('frontend/ar/js/bootstrap.min.js');
        } else {
            $css = url('frontend/en/css/bootstrap.min.css');
            $js = url('frontend/en/js/bootstrap.min.js');
        }

        return
            '<!DOCTYPE html>
           <html lang="en">
             <head>
               <meta charset="utf-8">
               <meta http-equiv="X-UA-Compatible" content="IE=edge">
               <meta name="viewport" content="width=device-width, initial-scale=1">
               <link href="' . $css . '" rel="stylesheet">
               <!--[if lt IE 9]>
                 <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                 <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
               <![endif]-->
             </head>
             <body>
               ' . $content . '
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
               <script src="' . $js . '"></script>
             </body>
           </html>';
    }
}

function getVariantsOfProduct($product)
{
    $options = [];

    foreach ($product->variantValues->unique('option_value_id') as $key => $value) {
        $options[$value->optionValue->option_id][] = $value;
    }

    return getOption($options);
}

function getOption($options)
{

    foreach ($options as $key => $value) {
        $id[$key] = [
            'option' => Option::find($key),
            'values' => $value
        ];
    }

    return $id;
}

function redirectAds($ads)
{
    $randomAdvertLink = '#';
    if (!is_null($ads)) {
        if (is_null($ads->morph_model)) {
            $randomAdvertLink = $ads->link;
        } elseif ($ads->morph_model == 'Category') {
            $category = Category::active()->find($ads->advertable_id);
            $randomAdvertLink = route('frontend.categories.show', $category->translate(locale())->slug);
        } elseif ($ads->morph_model == 'Product') {
            $product = Product::active()->find($ads->advertable_id);
            $randomAdvertLink = route('frontend.products.index', [$product->vendor->translate(locale())->slug, $product->translate(locale())->slug]);
        } elseif ($ads->morph_model == 'Brand') {
            $brand = Brand::active()->find($ads->advertable_id);
            $randomAdvertLink = route('frontend.categories.filters.show', ['brands' => [$brand->id]]);
        }
    }
    return $randomAdvertLink;
}

if (!function_exists('getDays')) {
    function getDays($dayCode = null)
    {
        if ($dayCode == null) {
            return [
                'sat' => __('apps::dashboard.availabilities.days.sat'),
                'sun' => __('apps::dashboard.availabilities.days.sun'),
                'mon' => __('apps::dashboard.availabilities.days.mon'),
                'tue' => __('apps::dashboard.availabilities.days.tue'),
                'wed' => __('apps::dashboard.availabilities.days.wed'),
                'thu' => __('apps::dashboard.availabilities.days.thu'),
                'fri' => __('apps::dashboard.availabilities.days.fri'),
            ];
        } else {
            switch ($dayCode) {
                case 'sat':
                    return __('apps::dashboard.availabilities.days.sat');
                    break;
                case 'sun':
                    return __('apps::dashboard.availabilities.days.sun');
                    break;
                case 'mon':
                    return __('apps::dashboard.availabilities.days.mon');
                case 'tue':
                    return __('apps::dashboard.availabilities.days.tue');
                    break;
                case 'wed':
                    return __('apps::dashboard.availabilities.days.wed');
                    break;
                case 'thu':
                    return __('apps::dashboard.availabilities.days.thu');
                    break;
                case 'fri':
                    return __('apps::dashboard.availabilities.days.fri');
                    break;
                default:
                    return 'not_exist';
            }
        }
    }
}
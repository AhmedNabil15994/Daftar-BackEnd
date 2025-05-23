<?php

// Dashboard ViewComposr
view()->composer([
    'catalog::dashboard.categories.*',
    'coupon::dashboard.*',
    'catalog::dashboard.products.create',
    'catalog::dashboard.products.clone',
    'catalog::dashboard.products.edit',
    'catalog::dashboard.products.index',
    'slider::dashboard.*',
    'advertising::dashboard.advertising.*',
    'popup_adds::dashboard.*',
], \Modules\Catalog\ViewComposers\Dashboard\CategoryComposer::class);

view()->composer([
    'catalog::dashboard.products.create',
    'catalog::dashboard.products.clone',
    'catalog::dashboard.products.edit',
    'advertising::dashboard.advertising.*',
    'popup_adds::dashboard.create',
    'popup_adds::dashboard.edit',
    'slider::dashboard.create',
    'slider::dashboard.edit',
], \Modules\Catalog\ViewComposers\Dashboard\BrandComposer::class);


view()->composer([
    'coupon::dashboard.*',
    'slider::dashboard.*',
    'advertising::dashboard.advertising.*',
    'popup_adds::dashboard.*',
], \Modules\Catalog\ViewComposers\Dashboard\ProductComposer::class);


// Frontend ViewComposr
view()->composer([
    'apps::frontend.layouts._header',
    'apps::frontend.index',
], Modules\Catalog\ViewComposers\FrontEnd\CategoryComposer::class);

// Vendor ViewComposr
view()->composer([
    'catalog::vendor.categories.*',
    'catalog::vendor.products.create',
    'catalog::vendor.products.clone',
    'catalog::vendor.products.edit',
], \Modules\Catalog\ViewComposers\Vendor\CategoryComposer::class);

view()->composer([
    'catalog::vendor.products.create',
    'catalog::vendor.products.clone',
    'catalog::vendor.products.edit',
], \Modules\Catalog\ViewComposers\Vendor\BrandComposer::class);

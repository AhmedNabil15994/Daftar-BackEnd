<?php

// DASHBOARD VIEW COMPOSER
view()->composer([
    'vendor::dashboard.vendors.*',
    'order::dashboard.orders.*',
], \Modules\Vendor\ViewComposers\Dashboard\PaymentComposer::class);

view()->composer(['vendor::dashboard.vendors.*'], \Modules\Vendor\ViewComposers\Dashboard\SectionComposer::class);

view()->composer([
    'order::dashboard.orders.*',
    'coupon::dashboard.*',
    'subscription::dashboard.subscriptions.*',
    'catalog::dashboard.products.*',
    'vendor::dashboard.delivery-charges.*',
    'advertising::dashboard.advertising.create',
    'advertising::dashboard.advertising.edit',
    'popup_adds::dashboard.create',
    'popup_adds::dashboard.edit',
    'slider::dashboard.create',
    'slider::dashboard.edit',
],
    \Modules\Vendor\ViewComposers\Dashboard\VendorComposer::class);

view()->composer([
    'apps::frontend.index',
],
    \Modules\Vendor\ViewComposers\FrontEnd\VendorComposer::class);

// VENDOR DASHBOARD VIEW COMPOSER
view()->composer(['apps::vendor.index'], \Modules\Vendor\ViewComposers\Vendor\VendorComposer::class);

view()->composer([
    'catalog::vendor.products.create',
    'catalog::vendor.products.edit',
    'catalog::vendor.products.clone',
    'order::vendor.orders.*',
],
    \Modules\Vendor\ViewComposers\Vendor\VendorComposer::class);

view()->composer([
    'order::vendor.orders.*',
], \Modules\Vendor\ViewComposers\Vendor\PaymentComposer::class);

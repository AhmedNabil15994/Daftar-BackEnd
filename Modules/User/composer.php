<?php

view()->composer(['order::dashboard.orders.*'], \Modules\User\ViewComposers\Dashboard\DriverComposer::class);
view()->composer(['order::vendor.orders.*'], \Modules\User\ViewComposers\Vendor\DriverComposer::class);
view()->composer(['vendor::dashboard.vendors.*'], \Modules\User\ViewComposers\Dashboard\SellerComposer::class);
view()->composer(['coupon::dashboard.*'], \Modules\User\ViewComposers\Dashboard\UserComposer::class);

view()->composer([
    'catalog::frontend.address.index',
],
    \Modules\User\ViewComposers\FrontEnd\UserAddressesComposer::class);

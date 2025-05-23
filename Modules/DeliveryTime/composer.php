<?php

// DASHBOARD VIEW COMPOSER
// view()->composer(['catalog::frontend.checkout.*'], \Modules\DeliveryTime\ViewComposers\FrontEnd\DeliveryTimeComposer::class);
// view()->composer(['order::dashboard.orders.*'], \Modules\DeliveryTime\ViewComposers\Dashboard\DeliveryTimeComposer::class);
view()->composer(['order::dashboard.orders.*'], \Modules\DeliveryTime\ViewComposers\Dashboard\DeliveryStatusComposer::class);

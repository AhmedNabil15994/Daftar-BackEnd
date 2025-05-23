<?php

view()->composer([
    'order::dashboard.orders.*',
], \Modules\Order\ViewComposers\Dashboard\OrderStatusComposer::class);

view()->composer([
    'order::vendor.orders.*',
], \Modules\Order\ViewComposers\Vendor\OrderStatusComposer::class);

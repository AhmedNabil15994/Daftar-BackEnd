<?php

return [
    'name' => 'Core',
    'image_mimes' => 'jpeg,png,jpg,gif,svg',
    'image_max' => '2048',
//    'default_img_path' => pathinfo(url(config('setting.logo')))['basename'] ?? null,
    'special_images' => ['default.png', 'user.png'],
    'user_img_path' => 'uploads/users',
    'vendor_img_path' => 'uploads/vendors',
    'brand_img_path' => 'uploads/brands',
    'category_img_path' => 'uploads/categories',
    'product_img_path' => 'uploads/products',
    'adverts_img_path' => 'uploads/adverts',
    'popup_ads_img_path' => 'uploads/popup_ads',
    'slider_img_path' => 'uploads/sliders',
    'settings_img_path' => 'uploads/settings',
];

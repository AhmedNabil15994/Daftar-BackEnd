<?php

return [
    'coupons' => [
        'datatable' => [
            'code' => 'Code',
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'expired_at' => 'Expired at',
            'image' => 'Image',
            'options' => 'Options',
            'status' => 'Status',
            'title' => 'title',
        ],
        'form' => [
            'categories' => 'Categories',
            'code' => 'Code',
            'description' => 'Brief description',
            'discount_percentage' => 'Discount Percentage',
            'discount_type' => 'Discount type',
            'discount_value' => 'Discount Value',
            'end_at' => 'End at',
            'expired_at' => 'Expired at',
            'image' => 'Image',
            'max_discount_percentage_value' => 'Max discount percentage value',
            'max_users' => 'Maximum number of users',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'packages' => 'Packages',
            'percentage' => 'Percentage',
            'products' => 'Products',
            'start_at' => 'Start at',
            'status' => 'Status',
            'tabs' => [
                'custom' => 'Customize the discount code',
                'general' => 'General Info.',
                'seo' => 'SEO',
                'use' => 'The validity of using the discount code',
            ],
            'title' => 'Title',
            'user_max_uses' => 'Maximum user usage',
            'users' => 'Users',
            'value' => 'Value',
            'vendors' => 'Vendors',
            'all_products' => 'All Products',
        ],
        'routes' => [
            'clone' => 'Clone coupons',
            'create' => 'Create coupons',
            'index' => 'coupons',
            'update' => 'Update coupons',
        ],
        'validation' => [
            'code' => [
                'unique' => 'This code is taken before',
            ],
            'discount_type' => [
                'required' => 'Please select discount type',
            ],
            'coupon_flag' => [
                'required' => ' Please select coupon type',
                'in' => 'coupon type in:vendors,categories,products',
            ],
            'discount_percentage' => [
                'required' => 'Please enter percentage value',
                'required_if' => 'Please enter percentage value',
            ],
        ],
    ],
];

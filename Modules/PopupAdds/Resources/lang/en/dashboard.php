<?php

return [
    'popup_adds' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'end_at' => 'End at',
            'image' => 'Image',
            'link' => 'Link',
            'options' => 'Options',
            'start_at' => 'Start at',
            'status' => 'Status',
            'type' => 'Type',
        ],
        'form' => [
            'end_at' => 'End at',
            'image' => 'Image',
            'link' => 'Link',
            'start_at' => 'Start at',
            'status' => 'Status',
            'sort' => 'Sort',
            'title' => 'Title',
            'short_description' => 'Short Description',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'products' => 'Products',
            'categories' => 'Categories',
            'vendors' => 'Vendors',
            'brands' => 'Brands',
            'popup_adds_type' => [
                'label' => 'Link Type',
                'external' => 'External',
                'product' => 'Product',
                'category' => 'Category',
                'vendor' => 'Vendor',
                'brand' => 'Brand',
            ],
        ],
        'alert' => [
            'select_vendor' => 'Choose Vendor',
            'select_categories' => 'Choose Product Category',
            'select_products' => 'Choose Product',
            'select_brand' => 'Choose Brand',
        ],
        'routes' => [
            'create' => 'Create Popup Adds',
            'index' => 'Popup Adds',
            'update' => 'Update Popup Adds',
        ],
        'validation' => [
            'end_at' => [
                'required' => 'Please select popup adds end at',
            ],
            'image' => [
                'required' => 'Please select image of the popup adds',
            ],
            'link' => [
                'required' => 'Please add the link of popup adds',
                'required_if' => 'Please add the link of popup adds',
            ],
            'start_at' => [
                'required' => 'Please select the date of started popup adds',
            ],
            'title' => [
                'required' => 'Please add the title of popup adds',
            ],
            'popup_adds_type' => [
                'required' => 'Please select the type of popup adds',
                'in' => 'This type of popup adds must be in',
            ],
            'product_id' => [
                'required_if' => 'Please select the product',
                'exists' => 'The product of ad is not found',
            ],
            'category_id' => [
                'required_if' => 'Please select the category',
                'exists' => 'The category of ad is not found',
            ],
            'brand_id' => [
                'required' => 'Please choose brand',
                'exists' => 'The brand of ad is not found',
            ],
            'vendor_id' => [
                'required_if' => 'Please select the vendor',
                'exists' => 'The vendor of ad is not found',
            ],
        ],
    ],
];

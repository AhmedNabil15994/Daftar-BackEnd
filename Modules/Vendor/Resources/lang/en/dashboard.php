<?php

return [
    'delivery_charges'  => [
        'create'    => [
            'form'  => [
                'delivery'  => 'Charge',
                'general'   => 'General Info.',
                'info'      => 'Info.',
                'state'     => 'State',
                'vendor'    => 'Vendor',
            ],
            'title' => 'Create Delivery Charges',
        ],
        'datatable' => [
            'charge'        => 'Charge',
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'delivery'      => 'Charge',
            'options'       => 'Options',
            'state'         => 'State',
            'vendor'        => 'Vendor',
        ],
        'index'     => [
            'title' => 'Delivery Charges',
        ],
        'update'    => [
            'form'  => [
                'delivery'  => 'Charge',
                'general'   => 'General info.',
                'state'     => 'State',
                'vendor'    => 'Vendor',
            ],
            'title' => 'Update Delivery Charges',
        ],
        'validation'=> [
            'delivery'  => [
                'numeric'   => 'Please enter the delivery charge numbers only',
                'required'  => 'Please enter the delivery charge',
            ],
            'state'     => [
                'numeric'   => 'Please select the state numbers only',
                'required'  => 'Please select the state',
            ],
            'vendor'    => [
                'numeric'   => 'Please select the vendor numbers only',
                'required'  => 'Please select the vendor',
            ],
        ],
    ],
    'payments'          => [
        'create'    => [
            'form'  => [
                'code'      => 'Payment Code',
                'general'   => 'General Info.',
                'image'     => 'Image',
                'info'      => 'Info.',
            ],
            'title' => 'Create Payments Methods',
        ],
        'datatable' => [
            'code'          => 'Code',
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
        ],
        'index'     => [
            'title' => 'Payments Methods',
        ],
        'update'    => [
            'form'  => [
                'code'      => 'Payment Code',
                'general'   => 'General info.',
                'image'     => 'Image',
            ],
            'title' => 'Update Payment Method',
        ],
        'validation'=> [
            'code'  => [
                'required'  => 'Please enter the code of payment method',
                'unique'    => 'This code of payment is taken before',
            ],
            'image' => [
                'required'  => 'Please enter the image of payment method',
            ],
        ],
    ],
    'sections'          => [
        'create'    => [
            'form'  => [
                'description'       => 'Description',
                'general'           => 'General Info.',
                'info'              => 'Info.',
                'meta_description'  => 'Meta Description',
                'meta_keywords'     => 'Meta Keywords',
                'seo'               => 'SEO',
                'status'            => 'Status',
                'title'             => 'Title',
            ],
            'title' => 'Create Vendors Sections',
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'index'     => [
            'title' => 'Vendors Sections',
        ],
        'update'    => [
            'form'  => [
                'description'       => 'Description',
                'general'           => 'General info.',
                'meta_description'  => 'Meta Description',
                'meta_keywords'     => 'Meta Keywords',
                'seo'               => 'SEO',
                'status'            => 'Status',
                'title'             => 'Title',
            ],
            'title' => 'Update Vendor Section',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'Please enter the description of section',
            ],
            'title'         => [
                'required'  => 'Please enter the title of section',
                'unique'    => 'This title section is taken before',
            ],
        ],
    ],
    'vendors'           => [
        'create'    => [
            'form'  => [
                'commission'        => 'Commission from vendor',
                'description'       => 'Description',
                'fixed_commission'  => 'Fixed Commission',
                'fixed_delivery'    => 'Fixed Delivery Fees',
                'general'           => 'General Info.',
                'image'             => 'Image',
                'info'              => 'Info.',
                'is_trusted'        => 'Is Trusted',
                'meta_description'  => 'Meta Description',
                'meta_keywords'     => 'Meta Keywords',
                'order_limit'       => 'Order Limit',
                'other'             => 'Other Info.',
                'payments'          => 'Allowed Payments',
                'sections'          => 'Vendor Section',
                'sellers'           => 'Vendor sellers',
                'seo'               => 'SEO',
                'status'            => 'Status',
                'title'             => 'Title',
            ],
            'title' => 'Create Vendors',
        ],
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'index'     => [
            'sorting'   => 'Sorting Vendors',
            'title'     => 'Vendors',
        ],
        'sorting'   => [
            'title' => 'Sorting Vendors',
        ],
        'update'    => [
            'form'  => [
                'commission'        => 'Commission from vendor',
                'description'       => 'Description',
                'general'           => 'General info.',
                'image'             => 'Image',
                'info'              => 'Info.',
                'is_trusted'        => 'Is Trusted',
                'meta_description'  => 'Meta Description',
                'meta_keywords'     => 'Meta Keywords',
                'order_limit'       => 'Order Limit',
                'other'             => 'Other Info.',
                'payments'          => 'Allowed Payments',
                'rating'            => 'Rating',
                'sections'          => 'Vendor Section',
                'sellers'           => 'Vendor sellers',
                'seo'               => 'SEO',
                'status'            => 'Status',
                'title'             => 'Title',
            ],
            'title' => 'Update Vendor',
        ],
        'validation'=> [
            'commission'        => [
                'numeric'   => 'Please add commission as numeric only',
                'required'  => 'Please add commission from vendor',
            ],
            'description'       => [
                'required'  => 'Please enter the description of vendor',
            ],
            'fixed_delivery'    => [
                'numeric'   => 'Please enter the fixed delivery fees as numbers only',
                'required'  => 'Please enter the fixed delivery fees.',
            ],
            'image'             => [
                'required'  => 'Please select vendor profile image',
            ],
            'months'            => [
                'numeric'   => 'Please enter the months as numbers only',
                'required'  => 'Please enter the months of the package',
            ],
            'order_limit'       => [
                'numeric'   => 'Please enter the order limit numeric only - ex : 5.000',
                'required'  => 'Please enter the order limit for this vendro ex : 5.000',
            ],
            'payments'          => [
                'required'  => 'Please select the allowed payments methods for this vendor',
            ],
            'price'             => [
                'numeric'   => 'Please enter the price numbers only',
                'required'  => 'Please enter the price of package',
            ],
            'sections'          => [
                'required'  => 'Please select the section of vendor',
            ],
            'sellers'           => [
                'required'  => 'Please select the sellers of this vendor',
            ],
            'special_price'     => [
                'numeric'   => 'Please enter the special price numbers only',
            ],
            'title'             => [
                'required'  => 'Please enter the title of vendor',
                'unique'    => 'This title vendor is taken before',
            ],
        ],
    ],
];

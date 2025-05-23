<?php

return [
    'products'  => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'image'         => 'Image',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
        ],
        'form'      => [
            'arrival_end_at'    => 'New Arrival End At',
            'arrival_start_at'  => 'New Arrival Start At',
            'arrival_status'    => 'New Arrival Status',
            'brands'            => 'Product Brand',
            'cost_price'        => 'Cost Price',
            'description'       => 'Description',
            'end_at'            => 'Offer End At',
            'image'             => 'Image',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'offer'             => 'Product Offer',
            'offer_price'       => 'Offer Price',
            'offer_status'      => 'Offer Status',
            'options'           => 'Options',
            'percentage'        => 'Percentage',
            'price'             => 'Price',
            'qty'               => 'Qty',
            'sku'               => 'SKU',
            'start_at'          => 'Offer Start At',
            'status'            => 'Status',
            'tabs'              => [
                'categories'    => 'Product Categories',
                'gallery'       => 'Image Gallery',
                'general'       => 'General Info.',
                'new_arrival'   => 'New Arrival',
                'seo'           => 'SEO',
                'stock'         => 'Stock & Price',
                'variations'    => 'Variations',
            ],
            'title'             => 'Title',
            'vendors'           => 'Product Vendor',
            'sort'              => 'Sort',
        ],
        'routes'    => [
            'create'    => 'Create Products',
            'index'     => 'Products',
            'update'    => 'Update Product',
        ],
        'validation'=> [
            'arrival_end_at'    => [
                'date'      => 'Please enter end at ( new arrival ) as date',
                'required'  => 'Please enter end at ( new arrival )',
            ],
            'arrival_start_at'  => [
                'date'      => 'Please enter start at ( new arrival ) as date',
                'required'  => 'Please enter end at ( new arrival )',
            ],
            'brand_id'          => [
                'required'  => 'Please select the brand',
            ],
            'category_id'       => [
                'required'  => 'Please select at least one category',
            ],
            'cost_price'        => [
                'lt'        => 'Cost price must be less than the price',
                'numeric'   => 'Please enter the cost price as numeric only',
                'required'  => 'Please enter the cost price',
            ],
            'end_at'            => [
                'date'      => 'Please enter end at ( offer ) as date',
                'required'  => 'Please enter end at ( offer )',
            ],
            'image'             => [
                'required'  => 'Please select image',
            ],
            'offer_price'       => [
                'numeric'   => 'Please enter the offer price as numeric only',
                'required'  => 'Please enter the offer price',
            ],
            'price'             => [
                'numeric'   => 'Please enter the price as numeric only',
                'required'  => 'Please enter the price',
            ],
            'qty'               => [
                'numeric'   => 'Please enter the quantity as numeric only',
                'required'  => 'Please enter the quantity',
            ],
            'sku'               => [
                'required'  => 'Please enter the SKU',
            ],
            'start_at'          => [
                'date'      => 'Please enter start at ( offer ) as date',
                'required'  => 'Please enter start at ( offer )',
            ],
            'title'             => [
                'required'  => 'Please enter the title',
                'unique'    => 'This title is taken before',
            ],
            'variation_price'   => [
                'required'  => 'Please add price of variants',
            ],
            'variation_qty'     => [
                'required'  => 'Please add Quantity of variants',
            ],
            'variation_sku'     => [
                'required'  => 'Please add SKU of variants',
            ],
            'variation_status'  => [
                'required'  => 'Please select status of variants',
            ],
            'vendor_id'         => [
                'required'  => 'Please select the vendor',
            ],
        ],
    ],
];

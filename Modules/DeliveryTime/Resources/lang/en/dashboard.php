<?php

return [
    'times' => [
        'datatable' => [
            'created_at'    => 'Created At',
            'date_range'    => 'Search By Dates',
            'from'          => 'From',
            'options'       => 'Options',
            'status'        => 'Status',
            'title'         => 'Title',
            'to'            => 'To',
        ],
        'form'      => [
            'description'       => 'Description',
            'from'              => 'From',
            'last_order'        => 'Last time will take order / Hrs',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'Status',
            'tabs'              => [
                'general'   => 'General Info.',
                'seo'       => 'SEO',
            ],
            'title'             => 'Title',
            'to'                => 'To',
            'type'              => 'In footer',
        ],
        'routes'    => [
            'create'    => 'Create Delivery Times',
            'index'     => 'Delivery Times',
            'update'    => 'Update Delivery Times',
        ],
        'validation'=> [
            'delivery_from' => [
                'required'  => 'Please select delivery from time',
            ],
            'delivery_to'   => [
                'required'  => 'Please select delivery to time',
            ],
            'description'   => [
                'required'  => 'Please enter the description of delivery time',
            ],
            'title'         => [
                'required'  => 'Please enter the title of delivery time',
                'unique'    => 'This title delivery time is taken before',
            ],
        ],
    ],
];

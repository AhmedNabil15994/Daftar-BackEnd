<?php

return [
    'times' => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'from'          => 'من',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
            'to'            => 'الى',
        ],
        'form'      => [
            'description'       => 'الوصف',
            'from'              => 'من',
            'last_order'        => 'اخر موعد لاستلام المواعيد / ساعات',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'status'            => 'الحالة',
            'tabs'              => [
                'general'   => 'بيانات عامة',
                'seo'       => 'SEO',
            ],
            'title'             => 'عنوان توقيت التوصيل',
            'to'                => 'الى',
            'type'              => 'في تذيل توقيت التوصيل',
        ],
        'routes'    => [
            'create'    => 'اضافة توقيتات توصيل',
            'index'     => 'توقيتات توصيل',
            'update'    => 'تعديل توقيت التوصيل',
        ],
        'validation'=> [
            'delivery_from' => [
                'required'  => 'Please select delivery from time',
            ],
            'delivery_to'   => [
                'required'  => 'Please select delivery to time',
            ],
            'description'   => [
                'required'  => 'من فضلك ادخل وصف توقيت التوصيل',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان توقيت التوصيل',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];

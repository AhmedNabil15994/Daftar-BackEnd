<?php

return [
    'cities' => [
      'form'  => [
          'countries' => 'اختر الدولة',
          'status'    => 'الحالة',
          'title'     => 'العنوان',
          'tabs'  => [
            'general'   => 'بيانات عامة',
          ]
      ],
      'datatable' => [
          'countries' => 'الدولة',
          'created_at'=> 'تاريخ الآنشاء',
          'options'   => 'الخيارات',
          'status'    => 'الحالة',
          'title'     => 'العنوان',
      ],
      'routes'     => [
          'create' => 'اضافة المحافظات',
          'index' => 'المحافظات',
          'update' => 'تعديل المحافظة',
      ],
      'validation'=> [
          'country_id'    => [
              'required'  => 'من فضلك اختر الدولة',
          ],
          'title'         => [
              'required'  => 'من فضلك ادخل العنوان',
              'unique'    => 'هذا العنوان تم ادخالة من قبل',
          ],
      ],
    ],

    'countries' => [
      'form'  => [
          'status'    => 'الحالة',
          'title'     => 'العنوان',
          'tabs'  => [
            'general'   => 'بيانات عامة',
          ]
      ],
      'datatable' => [
          'created_at'    => 'تاريخ الآنشاء',
          'options'       => 'الخيارات',
          'status'        => 'الحالة',
          'title'         => 'العنوان',
      ],
      'routes'     => [
          'create' => 'اضافة الدول',
          'index'  => 'الدول',
          'update' => 'Update Page',
          'update' => 'تعديل الدولة',
      ],
      'validation'=> [
          'title' => [
              'required'  => 'من فضلك ادخل العنوان',
              'unique'    => 'هذا العنوان تم ادخالة من قبل',
          ],
      ],
    ],

    'states' => [
      'form'  => [
          'cities'    => 'اختر المنطقة',
          'status'    => 'الحالة',
          'title'     => 'العنوان',
          'tabs'  => [
            'general'   => 'بيانات عامة',
          ]
      ],
      'datatable' => [
          'cities'        => 'المحافظة',
          'created_at'    => 'تاريخ الآنشاء',
          'options'       => 'الخيارات',
          'status'        => 'الحالة',
          'title'         => 'العنوان',
      ],
      'routes'     => [
          'create' => 'اضافة المناطق',
          'index' => 'المناطق',
          'update' => 'تعديل المنطقة',

      ],
      'validation'=> [
          'city_id'   => [
              'required'  => 'من فضلك اختر الدولة',
          ],
          'title'     => [
              'required'  => 'من فضلك ادخل العنوان',
              'unique'    => 'هذا العنوان تم ادخالة من قبل',
          ],
      ],
    ],
];

<?php

return [
    'delivery_charges'  => [
        'create'    => [
            'form'  => [
                'delivery'  => 'قيمة التوصيل',
                'general'   => 'بيانات عامة',
                'info'      => 'البيانات',
                'state'     => 'Meta Description',
                'vendor'    => 'المتجر',
            ],
            'title' => 'اضافة قيم التوصيل',
        ],
        'datatable' => [
            'charge'        => 'القيمة',
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'delivery'      => 'قيم التوصيل',
            'options'       => 'الخيارات',
            'state'         => 'عدد مناطق التوصيل',
            'vendor'        => 'المتجر',
        ],
        'index'     => [
            'title' => 'قيم التوصيل',
        ],
        'update'    => [
            'form'  => [
                'delivery'  => 'قيمة التوصيل',
                'general'   => 'بيانات عامة',
                'state'     => 'المنطقة',
                'vendor'    => 'المتجر',
            ],
            'title' => 'تعديل قيم التوصيل',
        ],
        'validation'=> [
            'delivery'  => [
                'numeric'   => 'من فضلك ادخل قيمة التوصيل ارقام فقط',
                'required'  => 'من فضلك ادخل قيمة التوصيل',
            ],
            'state'     => [
                'numeric'   => 'من فضلك اختر المنطقة ارقام فقط',
                'required'  => 'من فضلك اختر المنطقة',
            ],
            'vendor'    => [
                'numeric'   => 'من فضلك اختر المتجر ارقام فقط',
                'required'  => 'من فضلك اختر المتجر',
            ],
        ],
    ],
    'payments'          => [
        'create'    => [
            'form'  => [
                'code'      => 'كود الدفع',
                'general'   => 'بيانات عامة',
                'image'     => 'الصورة',
                'info'      => 'البيانات',
            ],
            'title' => 'اضافة طرق الدفع',
        ],
        'datatable' => [
            'code'          => 'كود الدفع',
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'الصورة',
            'options'       => 'الخيارات',
        ],
        'index'     => [
            'title' => 'طرق الدفع',
        ],
        'update'    => [
            'form'  => [
                'code'      => 'كود الدفع',
                'general'   => 'بيانات عامة',
                'image'     => 'الصورة',
            ],
            'title' => 'تعديل طريقة الدفع',
        ],
        'validation'=> [
            'code'  => [
                'required'  => 'من فضلك ادخل كود الدفع',
                'unique'    => 'هذا الكود تم ادخالة من قبل',
            ],
            'image' => [
                'required'  => 'من فضلك اختر الصورة',
            ],
        ],
    ],
    'sections'          => [
        'create'    => [
            'form'  => [
                'description'       => 'الوصف',
                'general'           => 'بيانات عامة',
                'info'              => 'البيانات',
                'meta_description'  => 'Meta Description',
                'meta_keywords'     => 'Meta Keywords',
                'seo'               => 'SEO',
                'status'            => 'الحالة',
                'title'             => 'عنوان القسم',
            ],
            'title' => 'اضافة اقسام المتاجر',
        ],
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'index'     => [
            'title' => 'اقسام المتاجر',
        ],
        'update'    => [
            'form'  => [
                'description'       => 'الوصف',
                'general'           => 'بيانات عامة',
                'meta_description'  => 'Meta Description',
                'meta_keywords'     => 'Meta Keywords',
                'seo'               => 'SEO',
                'status'            => 'الحالة',
                'title'             => 'عنوان القسم',
            ],
            'title' => 'تعديل اقسام المتاجر',
        ],
        'validation'=> [
            'description'   => [
                'required'  => 'من فضلك ادخل وصف القسم',
            ],
            'title'         => [
                'required'  => 'من فضلك ادخل عنوان القسم',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
    'vendors'           => [
        'create'    => [
            'form'  => [
                'commission'        => 'نسبة الربح من المتجر',
                'description'       => 'الوصف',
                'fixed_commission'  => 'نسبة ربح ثابتة',
                'fixed_delivery'    => 'سعر التوصيل الثابت',
                'general'           => 'بيانات عامة',
                'image'             => 'الصورة',
                'info'              => 'البيانات',
                'is_trusted'        => 'صلاحيات الاضافة',
                'meta_description'  => 'Meta Description',
                'meta_keywords'     => 'Meta Keywords',
                'order_limit'       => 'الحد الادنى للطلب',
                'other'             => 'بيانات اخرى',
                'payments'          => 'طرق الدفع المدعومة',
                'sections'          => 'قسم المتجر',
                'sellers'           => 'بائعين المتجر',
                'seo'               => 'SEO',
                'status'            => 'الحالة',
                'title'             => 'عنوان',
            ],
            'title' => 'اضافة المتاجر',
        ],
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'الصورة',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'index'     => [
            'sorting'   => 'ترتيب المتاجر',
            'title'     => 'المتاجر',
        ],
        'sorting'   => [
            'title' => 'ترتيب المتاجر',
        ],
        'update'    => [
            'form'  => [
                'commission'        => 'نسبة الربح من المتجر',
                'description'       => 'الوصف',
                'general'           => 'بيانات عامة',
                'image'             => 'الصورة',
                'info'              => 'البيانات',
                'is_trusted'        => 'صلاحيات الاضافة',
                'meta_description'  => 'Meta Description',
                'meta_keywords'     => 'Meta Keywords',
                'order_limit'       => 'الحد الادنى للطلب',
                'other'             => 'بيانات اخرى',
                'payments'          => 'طرق الدفع المدعومة',
                'rating'            => 'التقييمات',
                'sections'          => 'قسم المتجر',
                'sellers'           => 'بائعين المتجر',
                'seo'               => 'SEO',
                'status'            => 'الحالة',
                'title'             => 'عنوان',
            ],
            'title' => 'تعديل المتجر',
        ],
        'validation'=> [
            'commission'        => [
                'numeric'   => 'من فضلك ادخل نسبه الربح ارقام انجليزية فقط',
                'required'  => 'من فضلك ادخل نسبه الربح',
            ],
            'description'       => [
                'required'  => 'من فضلك ادخل الوصف',
            ],
            'fixed_delivery'    => [
                'numeric'   => 'من فضلك ادخل سعر التوصيل الثابت ارقام انجليزية فقط',
                'required'  => 'من فضلك ادخل سعر التوصيل الثابت',
            ],
            'image'             => [
                'required'  => 'من فضلك اختر صورة المتجر',
            ],
            'months'            => [
                'numeric'   => 'من فضلك ادخل عدد شهور الباقة ارقام فقط',
                'required'  => 'من فضلك ادخل عدد شهور الباقة',
            ],
            'order_limit'       => [
                'numeric'   => 'من فضلك ادخل الاحد الادنى كا ارقام انجليزية فقط : 5.000',
                'required'  => 'من فضلك ادخل الحد الادنى للمتجر : 5.000',
            ],
            'payments'          => [
                'required'  => 'من فضلك اختر طرق الدفع المدعومة من قبل هذا المتجر',
            ],
            'price'             => [
                'numeric'   => 'من فضلك ادخل سعر الباقة ارقام فقط',
                'required'  => 'من فضلك ادخل سعر الباقة',
            ],
            'sections'          => [
                'required'  => 'من فضلك اختر قسم المتجر',
            ],
            'sellers'           => [
                'required'  => 'من فضلك اختر البائعين لهذا المتجر',
            ],
            'special_price'     => [
                'numeric'   => 'من فضلك ادخل السعر الخاص ارقام فقط',
            ],
            'title'             => [
                'required'  => 'من فضلك ادخل العنوان',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
];

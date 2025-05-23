<?php

return [
    'coupons' => [
        'datatable' => [
            'code' => 'الكود',
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'expired_at' => 'تاريخ انتهاء الصلاحية',
            'image' => 'الصورة',
            'options' => 'الخيارات',
            'status' => 'الحاله',
            'title' => 'العنوان',
        ],
        'form' => [
            'categories' => 'الأقسام',
            'code' => 'كود الخصم',
            'description' => 'وصف مختصر',
            'discount_percentage' => 'نسبة الخصم',
            'discount_type' => 'نوع الخصم',
            'discount_value' => 'قيمة الخصم',
            'end_at' => 'ينتهي في تاريخ',
            'expired_at' => 'تاريخ انتهاء الصلاحية',
            'image' => 'الصورة',
            'max_discount_percentage_value' => 'قيمة الحد الأقصى للخصم',
            'max_users' => 'أقصى عدد للمستخدمين',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'packages' => 'الباقات',
            'percentage' => 'نسبة',
            'products' => 'المنتجات',
            'start_at' => 'تاريخ بداية الصلاحية',
            'status' => 'الحالة',
            'tabs' => [
                'custom' => 'تخصيص كود الخصم',
                'general' => 'بيانات عامة',
                'seo' => 'SEO',
                'use' => 'صلاحية واستخدام كود الخصم',
            ],
            'title' => 'عنوان',
            'user_max_uses' => 'أقصى عدد لاستخدام المستخدم',
            'users' => 'المستخدمون',
            'value' => 'قيمة',
            'vendors' => 'المتاجر',
            'all_products' => 'كل المنتجات',
        ],
        'routes' => [
            'clone' => 'نسخ كوبون خصم',
            'create' => 'اضافة كوبون خصم',
            'index' => 'كوبونات الخصم',
            'update' => 'تعديل كوبون خصم',
        ],
        'validation' => [
            'code' => [
                'unique' => 'هذا الكود تم ادخالة من قبل',
            ],
            'discount_type' => [
                'required' => 'من فضلك ادخل نوع الخصم',
            ],
            'coupon_flag' => [
                'required' => 'من فضلك اختر تخصيص الخصم',
                'in' => 'تخصيص الخصم ضمن:vendors,categories,products',
            ],
            'discount_percentage' => [
                'required' => 'من فضلك ادخل قيمة النسبة المئوية',
                'required_if' => 'من فضلك ادخل قيمة النسبة المئوية',
            ],
        ],
    ],
];

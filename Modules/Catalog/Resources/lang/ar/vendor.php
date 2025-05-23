<?php

return [
    'products'  => [
        'datatable' => [
            'created_at'    => 'تاريخ الآنشاء',
            'date_range'    => 'البحث بالتواريخ',
            'image'         => 'الصورة',
            'options'       => 'الخيارات',
            'status'        => 'الحالة',
            'title'         => 'العنوان',
        ],
        'form'      => [
            'arrival_end_at'    => 'تاريخ الانتهاء',
            'arrival_start_at'  => 'تاريخ البدء',
            'arrival_status'    => 'حالة الوصول حديثا',
            'brands'            => 'العلامة التجارية للمنتج',
            'cost_price'        => 'سعر الشراء',
            'description'       => 'الوصف',
            'end_at'            => 'ينتهي التخفيض بتاريخ',
            'image'             => 'الصورة',
            'meta_description'  => 'Meta Description',
            'meta_keywords'     => 'Meta Keywords',
            'offer'             => 'تخفيض للمنتج',
            'offer_price'       => 'السعر بعد التخفيض',
            'offer_status'      => 'حالة التخفيض',
            'options'           => 'اختيارات',
            'percentage'        => 'نسبة مئوية',
            'price'             => 'السعر',
            'qty'               => 'الكمية',
            'sku'               => 'كود المنتج',
            'start_at'          => 'يبدا التخفيض بتاريخ',
            'status'            => 'الحالة',
            'tabs'              => [
                'categories'    => 'اقسام المنتج',
                'gallery'       => 'معرض الصور',
                'general'       => 'بيانات عامة',
                'new_arrival'   => 'وصل حديثا',
                'seo'           => 'SEO',
                'stock'         => 'المخزون و السعر',
                'variations'    => 'اختلافات المنتج',
            ],
            'title'             => 'عنوان',
            'vendors'           => 'متجر المنتج',
            'sort'              => 'الترتيب',
        ],
        'routes'    => [
            'create'    => 'اضافة المنتجات',
            'index'     => 'المنتجات',
            'update'    => 'تعديل المنتج',
        ],
        'validation'=> [
            'arrival_end_at'    => [
                'date'      => 'من فضلك ادخل تاريخ الانتهاء - وصل حديثا كتاريخ فقط',
                'required'  => 'من فضلك ادخل تاريخ الانتهاء - وصل حديثا',
            ],
            'arrival_start_at'  => [
                'date'      => 'من فضلك ادخل تاريخ البدء - وصل حديثا كتاريخ فقط',
                'required'  => 'من فضلك ادخل تاريخ البدء - وصل حديثا',
            ],
            'brand_id'          => [
                'required'  => 'من فضلك اختر العلامة التجارية',
            ],
            'category_id'       => [
                'required'  => 'من فضلك اختر على الاقل قسم واحد',
            ],
            'cost_price'        => [
                'lt'        => 'سعر الشراء يجب ان يكون اصغر من سعر البيع',
                'numeric'   => 'من فضلك ادخل سعر الشراء ارقام فقط',
                'required'  => 'من فضلك ادخل سعر الشراء',
            ],
            'end_at'            => [
                'date'      => 'من فضلك ادخل تاريخ الانتهاء - الخصم كتاريخ فقط',
                'required'  => 'من فضلك ادخل تاريخ الانتهاء - الخصم',
            ],
            'image'             => [
                'required'  => 'من فضلك اختر الصورة',
            ],
            'offer_price'       => [
                'numeric'   => 'من فضلك ادخل سعر الخصم للمنتج ارقام فقط',
                'required'  => 'من فضلك ادخل سعر الخصم للمنتج',
            ],
            'price'             => [
                'numeric'   => 'من فضلك ادخل السعر ارقام فقط',
                'required'  => 'من فضلك ادخل السعر',
            ],
            'qty'               => [
                'numeric'   => 'من فضلك ادخل الكمية ارقام فقط',
                'required'  => 'من فضلك ادخل الكمية',
            ],
            'sku'               => [
                'required'  => 'من فضلك ادخل كود المنتج',
            ],
            'start_at'          => [
                'date'      => 'من فضلك ادخل تاريخ البدء - الخصم كتاريخ فقط',
                'required'  => 'من فضلك ادخل تاريخ البدء - الخصم',
            ],
            'title'             => [
                'required'  => 'من فضلك ادخل العنوان',
                'unique'    => 'هذا العنوان تم ادخالة من قبل',
            ],
            'variation_price'   => [
                'required'  => 'من فضلك ادخل سعر المنتج الاختياري',
            ],
            'variation_qty'     => [
                'required'  => 'من فضلك ادخل كمية المنتج الاختياري',
            ],
            'variation_sku'     => [
                'required'  => 'من فضلك ادخل كود المنتج الاختياري',
            ],
            'variation_status'  => [
                'required'  => 'من فضلك اختر حالة المنتج الاختياري',
            ],
            'vendor_id'         => [
                'required'  => 'من فضلك اختر المتجر',
            ],
        ],
    ],
];

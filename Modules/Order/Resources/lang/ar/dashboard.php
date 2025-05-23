<?php

return [
    'order_statuses' => [
        'datatable' => [
            'color_label' => 'لون الحالة',
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'failed_status' => 'حالة طلب غير ناجحة',
            'label_color' => 'لون الحالة',
            'options' => 'الخيارات',
            'success_status' => 'حالة طلب ناجحة',
            'title' => 'العنوان',
        ],
        'form' => [
            'color_label' => 'لون الحالة',
            'failed_status' => 'حالة طلب غير ناجحة',
            'label_color' => 'لون الحالة',
            'success_status' => 'حالة طلب ناجحة',
            'tabs' => [
                'general' => 'بيانات عامة',
            ],
            'title' => 'عنوان الحالة',
        ],
        'routes' => [
            'create' => 'اضافة حالات الطلبات',
            'index' => 'حالات الطلبات',
            'update' => 'تعديل حالة الطلبات',
        ],
        'validation' => [
            'color_label' => [
                'required' => 'من فضلك اختر لون / نوع الحالة',
            ],
            'label_color' => [
                'required' => 'من فضلك اختر لون / نوع الحالة',
            ],
            'title' => [
                'required' => 'من فضلك ادخل عنوان الحالة',
                'unique' => 'هذا العنوان تم ادخالة من قبل',
            ],
        ],
    ],
    'orders' => [
        'datatable' => [
            'created_at' => 'تاريخ الآنشاء',
            'date_range' => 'البحث بالتواريخ',
            'driver' => 'السائق',
            'method' => 'طريقة الدفع',
            'options' => 'الخيارات',
            'shipping' => 'التوصيل',
            'status' => 'حالة الطلب',
            'subtotal' => 'المجموع',
            'time' => 'وقت التوصيل',
            'total' => 'المجموع الكلي',
            'total_profit_comission' => 'نسبة الربح',
            'vendor_id' => 'المتجر',
            'delivery_status' => 'حالة التوصيل',
        ],
        'emails' => [
            'drivers' => [
                'subject' => 'طلب جديد',
            ],
        ],
        'index' => [
            'statistics' => [
                'canceled_orders' => 'الطلبات الملغية',
                'failed_orders' => 'الطلبات الغير صحيحة',
                'returned_orders' => 'الطلبات المسترده',
                'success_orders' => 'الطلبات الناجحة',
            ],
            'title' => 'الطلبات',
        ],
        'reports' => [
            'title' => 'تقارير الطلبات',
        ],
        'show' => [
            'address' => [
                'block' => 'القطعه',
                'building' => 'البنايه',
                'city' => 'المحافظة',
                'data' => 'بيانات عنوان التوصيل',
                'details' => 'تفاصيل العنوان',
                'state' => 'المنطقة',
                'street' => 'الشارع',
            ],
            'drivers' => [
                'title' => 'السائقين',
                'assign' => 'اسناد الى سائق',
                'no_drivers' => 'لا يوجد سائقين حالياً',
                'status' => 'حالة الطلب',
                'delivery_status' => 'حالة التوصيل',
                'time' => 'وقت التوصيل',
                'change_order_status' => 'تعديل حالة الطلب',
            ],
            'payment' => [
                'title' => 'طريقة الدفع',
            ],
            'edit' => 'تعديل حالة الطلب',
            'invoice' => 'الفاتورة',
            'invoice_customer' => 'فاتورة العميل',
            'invoice_vendor' => 'فاتورة المتجر',
            'notes' => 'ملاحظات المتجر',
            'user_notes' => 'ملاحظات العميل',
            'items' => [
                'data' => 'المنتجات',
                'off' => 'الخصم',
                'options' => 'خيارات',
                'price' => 'السعر',
                'qty' => 'الكمية',
                'title' => 'اسم المنتج',
                'total' => 'المجموع',
            ],
            'order' => [
                'data' => 'بيانات الطلب',
                'delivery_time' => 'وقت التوصيل',
                'off' => 'الخصم',
                'shipping' => 'التوصيل',
                'subtotal' => 'المجموع',
                'total' => 'المجموع الكلي',
            ],
            'other' => [
                'data' => 'بيانات اضافية',
                'total_comission' => 'نسبة الربح من المتجر',
                'total_profit' => 'ربح الفرق ( الشراء و البيع )',
                'total_profit_comission' => 'مجموع الارباح',
                'vendor' => 'المتجر',
            ],
            'title' => 'عرض الطلب',
            'user' => [
                'data' => 'بيانات العميل',
                'email' => 'البريد الالكتروني',
                'mobile' => 'رقم الهاتف',
                'username' => 'اسم العميل',
            ],
        ],
        'success' => [
            'statistics' => [
                'canceled_orders' => 'الطلبات الملغية',
                'failed_orders' => 'الطلبات الغير صحيحة',
                'returned_orders' => 'الطلبات المسترده',
                'success_orders' => 'الطلبات الناجحة',
            ],
            'title' => 'الطلبات المكتملة',
        ],
    ],
    'order_drivers' => [
        'validation' => [
            'qty_is_not_available_for_product' => 'الكمية غير متاحة للمنتج',
            'product_not_found' => 'المنتج غير متاح حاليا',
            'user_id' => [
                'required' => 'من فضلك اختر السائق',
                'exists' => 'هذا السائق غير موجود حاليا',
            ],
            'order_status' => [
                'required' => 'من فضلك اختر حالة الطلب',
                'exists' => 'حالة الطلب غير موجودة حاليا',
            ],
            'payment_method' => [
                'required' => 'من فضلك اختر طريقة الدفع',
                'exists' => 'طريقة الدفع غير موجودة حاليا',
            ],
        ],
    ],
];

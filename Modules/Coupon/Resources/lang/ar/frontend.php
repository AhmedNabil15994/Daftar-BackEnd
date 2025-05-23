<?php

return [
    'coupons'   => [
        'enter'=>'ادخل الكوبون',
        'validation'=> [

            'code'      => [
                'required'  => 'من فضلك ادخل كود الخصم',
                'exists'  => 'هذا الكود غير صحيح ',
                'expired'  => 'هذا الكود غير صالح ',
                'custom'  => 'هذا الكود غير مخصص لك ',
                // 'custom'  => 'هذا الكود غير مخصص لك او لهذا المتجر ',
                'not_found'  => 'هذا الكود غير موجود ',
            ],
            'product'      => [
                'required'  => 'من فضلك ادخل ارقام المنتجات داخل السلة',
                'exists'  => 'ارقام المنتجات داخل السلة يجب ان تكون array',
            ],

        ],
    ],
];

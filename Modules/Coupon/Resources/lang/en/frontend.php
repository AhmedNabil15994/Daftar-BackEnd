<?php

return [
    'coupons'   => [
        'enter'=>'Enter Coupon',
        'validation'=> [

            'code'      => [
                'required'  => 'Please Enter Code',
                'exists'  => 'This Code Is invalid',
                'expired'  => 'This Code Is expired',
                'custom'  => 'This Code Is not available for you',
                // 'custom'  => 'This Code Is not available for you or this vendor',
                'not_found'  => 'This Code Is not found',
            ],
            'product'      => [
                'required'  => 'Please enter cart products ids',
                'exists'  => 'Cart products ids should be array',
            ],

        ],
    ],
];

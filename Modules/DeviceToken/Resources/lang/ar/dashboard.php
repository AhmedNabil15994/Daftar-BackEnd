<?php

return [
    'devicetokens' => [
        'form' => [
            'description' => 'الوصف',
            'title' => 'العنوان',
            'tabs' => [
                'general' => 'بيانات عامة',
            ],
        ],
        'routes' => [
            'index' => 'ارسال اشعارات عامة',
        ],
        'validation' => [
            'title' => [
                'required' => 'من فضلك ادخل العنوان',
                'max' => 'العنوان يجب ألا يتجاوز عدد حروفه',
            ],
            'description' => [
                'required' => 'من فضلك ادخل الوصف',
                'max' => 'الوصف يجب ألا يتجاوز عدد حروفه',
            ],
        ],
    ],
];

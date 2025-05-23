<?php

return [
    'devicetokens' => [
        'form' => [
            'description' => 'Description',
            'title' => 'Title',
            'tabs' => [
                'general' => 'General Info.',
            ],
        ],
        'routes' => [
            'index' => 'Send Mobile General Notifications',
        ],
        'validation' => [
            'title' => [
                'required' => 'Please enter title',
                'max' => 'Title must not exceed characters',
            ],
            'description' => [
                'required' => 'Please enter description',
                'max' => 'Description must not exceed characters',
            ],
        ],
    ],
];

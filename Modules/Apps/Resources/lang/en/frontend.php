<?php

return [
    'contact_us'    => [
        'alerts'        => [
            'rate_message'  => 'Rating Successfully',
            'send_message'  => 'Message Sent Successfully',
        ],
        'form'          => [
            'btn'       => [
                'send'  => 'Send',
            ],
            'email'     => 'Email',
            'message'   => 'Message',
            'mobile'    => 'Mobile',
            'username'  => 'Name',
        ],
        'info'          => [
            'email' => 'Email address',
            'mobile'=> 'Mobile',
            'title' => 'Informations',
        ],
        'mail'          => [
            'header'    => 'We received new contact us mail',
            'subject'   => 'Contact Us Mail',
        ],
        'title'         => 'Contact Us',
        'title_2'       => 'Send message for us',
        'validations'   => [
            'email'     => [
                'email'     => 'Please enter correct email',
                'required'  => 'Please enter the email address',
            ],
            'message'   => [
                'min'       => 'Message must be more than 10 characters',
                'required'  => 'Please fill the message of contact us',
                'string'    => 'please enter only characters and numbers in message',
            ],
            'mobile'    => [
                'digits_between'    => 'You must enter mobile number with 8 digits',
                'numeric'           => 'Please enter correct mobile number',
                'required'          => 'Please enter mobile number',
            ],
            'username'  => [
                'min'       => 'Name must be more than 3 character',
                'required'  => 'Please enter name',
                'string'    => 'Please enter name with only characters and numbers',
            ],
        ],
    ],
    'footer'        => [
        'tocaan'        => 'Tocaan Co.',
        'developed_by'  => 'Design & Developed By',
        'contact_us'    => 'Contact Us',
        'helper_links'  => 'Helper Links',
        'home_page'     => 'Home',
        'payments'      => 'Payments',
        'site_map'      => 'Site Map',
        'whatsapp'      => 'WhatsApp',
    ],
    'general'       => [
        'add_to_cart'       => 'Add to cart',
        'kwd'               => 'KWD',
        'update_item_cart'  => 'Update',
    ],
    'home'          => [
        'search_btn'    => 'Search',
        'search_holder' => 'Search for store or product',
        'title'         => 'Daftar home page',
        'view_more_btn' => 'View More',
    ],
    'nav'           => [
        'contact_us_page'   => 'Contact Us',
        'home_page'         => 'Home',
        'login'             => 'Login',
        'register'          => 'Register',
    ],
];

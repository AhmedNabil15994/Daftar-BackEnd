<?php

return [
    'login'     => [
        'form'          => [
            'btn'           => [
                'forget_password'   => 'Forget Password ?',
                'login'             => 'Login',
            ],
            'email'         => 'E-mail address',
            'password'      => 'Password',
            'remember_me'   => 'Remember Me',
        ],
        'title'         => 'Login',
        'validation'    => [
            'email'     => [
                'email'     => 'Please enter correct email format',
                'required'  => 'The email field is required',
            ],
            'failed'    => 'These credentials do not match our records.',
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'The password field is required',
            ],
        ],
    ],
    'password'  => [
        'alert'         => [
            'reset_sent'    => 'Reset password sent successfully',
        ],
        'form'          => [
            'btn'   => [
                'password'  => 'Send Reset Password',
            ],
            'email' => 'Email address',
        ],
        'title'         => 'Forget Password',
        'validation'    => [
            'email' => [
                'email'     => 'Please enter correct email format',
                'exists'    => 'This email not exists',
                'required'  => 'The email field is required',
            ],
        ],
    ],
    'register'  => [
        'alert'         => [
            'policy_privacy'    => 'if you register it mean you are confirm',
        ],
        'btn'           => [
            'policy_privacy'    => 'Policy & Privacy',
            'register'          => 'Register',
        ],
        'form'          => [
            'email'                 => 'Email Address',
            'mobile'                => 'Mobile',
            'name'                  => 'Name',
            'password'              => 'Password',
            'password_confirmation' => 'Password Confirmation',
        ],
        'title'         => 'Registration',
        'validation'    => [
            'email'     => [
                'email'     => 'Please enter correct email format',
                'required'  => 'The email field is required',
                'unique'    => 'The email has already been taken',
            ],
            'mobile'    => [
                'digits_between'    => 'You must enter mobile number with 8 digits',
                'numeric'           => 'The mobile must be a number',
                'required'          => 'The mobile field is required',
                'unique'            => 'The mobile has already been taken',
            ],
            'name'      => [
                'required'  => 'The name field is required',
            ],
            'password'  => [
                'confirmed' => 'Password not match with the cnofirmation',
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'The password field is required',
            ],
        ],
    ],
    'reset'     => [
        'form'          => [
            'btn'                   => [
                'reset' => 'Reset Password Now',
            ],
            'email'                 => 'Email Address',
            'password'              => 'Password',
            'password_confirmation' => 'Password Confirmation',
        ],
        'mail'          => [
            'button_content'    => 'Reset Your Password',
            'header'            => 'You are receiving this email because we received a password reset request for your account.',
            'subject'           => 'Reset Password',
        ],
        'title'         => 'Reset Password',
        'validation'    => [
            'email'     => [
                'email'     => 'Please enter correct email format',
                'exists'    => 'This email not exists',
                'required'  => 'The email field is required',
            ],
            'password'  => [
                'min'       => 'Password must be more than 6 characters',
                'required'  => 'The password field is required',
            ],
            'token'     => [
                'exists'    => 'This token expired',
                'required'  => 'The token field is required',
            ],
        ],
    ],
];

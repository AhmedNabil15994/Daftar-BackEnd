<?php

return [
    'addresses' => [
        'btn'           => [
            'edit'  => 'Edit Address',
        ],
        'edit'          => [
            'title' => 'Edit Address',
        ],
        'form'          => [
            'address_details'   => 'Address Details',
            'block'             => 'Block Number',
            'building'          => 'Building Number',
            'email'             => 'E-mail address',
            'kuwait'            => 'Kuwait',
            'mobile'            => 'Mobile',
            'states'            => 'Chose State',
            'street'            => 'Street',
            'username'          => 'Username',
        ],
        'index'         => [
            'alert' => [
                'error'     => 'Opps! something happened try again later',
                'success'   => 'Address updates successfully',
                'success_'  => 'Address Added Successfully',
            ],
            'btn'   => [
                'add'       => 'Add New Address',
                'delete'    => 'Delete',
                'edit'      => 'Edit',
            ],
            'title' => 'My Addresses',
        ],
        'validations'   => [
            'address'   => [
                'min'       => 'Please add more details , must be more than 10 characters',
                'required'  => 'Please add address details',
                'string'    => 'Please add address details as string only',
            ],
            'block'     => [
                'required'  => 'Please enter the block',
                'string'    => 'You must add only characters or numbers in block',
            ],
            'building'  => [
                'required'  => 'Please enter the building number / name',
                'string'    => 'You must add only characters or numbers in building',
            ],
            'email'     => [
                'email'     => 'Email must be email format',
                'required'  => 'Please add your email',
            ],
            'mobile'    => [
                'digits_between'    => 'You must enter mobile number with 8 digits',
                'numeric'           => 'Please add mobile number as numbers only',
                'required'          => 'Please add mobile number',
            ],
            'state'     => [
                'numeric'   => 'Please chose state',
                'required'  => 'Please chose state',
            ],
            'street'    => [
                'required'  => 'Please enter the street name / number',
                'string'    => 'You must add only characters or numbers in street',
            ],
            'username'  => [
                'min'       => 'username must be more than 2 characters',
                'required'  => 'Please add username',
                'string'    => 'Please add username as string only',
            ],
        ],
    ],
    'profile'   => [
        'index' => [
            'favorites' => 'Favorite List',
            'addresses' => 'Addresses',
            'alert'     => [
                'error'     => 'Opss! something wrong please try again later',
                'success'   => 'Your profile updated succesfully',
            ],
            'form'      => [
                'btn'                   => [
                    'update'    => 'Update',
                ],
                'current_password'      => 'Current Password',
                'email'                 => 'Email Address',
                'mobile'                => 'Mobile',
                'name'                  => 'Username',
                'password'              => 'New Password',
                'password_confirmation' => 'Password Confirmation',
            ],
            'logout'    => 'Logout',
            'orders'    => 'My Orders',
            'title'     => 'Profile',
            'update'    => 'Update Profile',
            'validation'=> [
                'current_password'  => [
                    'not_matchh'    => 'Current password not matched with the saved password',
                    'required_with' => 'Please enter your current password',
                ],
                'email'             => [
                    'email'     => 'Please enter correct email format',
                    'required'  => 'The email field is required',
                    'unique'    => 'The email has already been taken',
                ],
                'mobile'            => [
                    'numeric'   => 'The mobile must be a number',
                    'required'  => 'The mobile field is required',
                    'unique'    => 'The mobile has already been taken',
                ],
                'name'              => [
                    'required'  => 'The name field is required',
                ],
                'password'          => [
                    'confirmed'     => 'Password not match with the cnofirmation',
                    'min'           => 'Password must be more than 6 characters',
                    'required'      => 'The password field is required',
                    'required_with' => 'Please enter your new password',
                ],
            ],
        ],
    ],
];

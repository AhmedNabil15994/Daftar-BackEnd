<?php

return [
    'orders'    => [
        'emails'        => [
            'admins'    => [
                'header'        => 'We received new order',
                'open_order'    => 'Open order',
                'subject'       => 'New Order',
            ],
            'users'     => [
                'header'        => 'Thank you for your order.',
                'open_order'    => 'Order Details',
                'rate_order'    => 'Rating Order Now',
                'subject'       => 'Dafatar Order',
            ],
            'vendors'   => [
                'header'        => 'We received new order',
                'open_order'    => 'Open order',
                'subject'       => 'New Order',
            ],
        ],
        'index'         => [
            'alerts'    => [
                'order_failed'  => 'Payment failed , please try again.',
                'order_success' => 'Thank you for order from our store , we will contact with you as soon as.',
            ],
            'btn'       => [
                'details'   => 'Order Details',
            ],
            'title'     => 'My Orders',
        ],
        'invoice'       => [
            'address'       => 'Address',
            'block'         => 'Block',
            'btn'           => [
                'print'     => 'Print',
                'reorder'   => 'Re Order',
            ],
            'building'      => 'Details',
            'date'          => 'Date',
            'details'       => 'Details',
            'email'         => 'Email',
            'method'        => 'Payment Method',
            'mobile'        => 'mobile',
            'product_qty'   => 'Qty',
            'product_title' => 'Title',
            'product_total' => 'Total',
            'shipping'      => 'Delivery',
            'street'        => 'Street',
            'subtotal'      => 'Subtotal',
            'title'         => 'Invoice',
            'total'         => 'Total',
            'username'      => 'Name',
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
            'date'      => [
                'required'  => 'Please select order date',
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
            'payment'   => [
                'required'  => 'Please select the payment',
            ],
            'state'     => [
                'numeric'   => 'Please chose state',
                'required'  => 'Please chose state',
            ],
            'street'    => [
                'required'  => 'Please enter the street name / number',
                'string'    => 'You must add only characters or numbers in street',
            ],
            'time'      => [
                'required'  => 'Please select delivery time',
            ],
            'username'  => [
                'min'       => 'username must be more than 2 characters',
                'required'  => 'Please add username',
                'string'    => 'Please add username as string only',
            ],
        ],
    ],
];

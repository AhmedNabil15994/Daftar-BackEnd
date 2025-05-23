<?php

return [
    'address'   => [
        'btn'           => [
            'add'           => 'Add address',
            'add_modal'     => 'Add New Address',
            'go_to_payment' => 'Continue Order',
        ],
        'form'          => [
            'address_details'   => 'Address Details',
            'as_guest'          => 'Order As Guest',
            'as_member'         => 'Order As Member',
            'block'             => 'Block Number',
            'building'          => 'Building Number',
            'email'             => 'E-mail address',
            'login'             => 'Login',
            'mobile'            => 'Mobile',
            'register'          => 'Register',
            'states'            => 'Choose State',
            'street'            => 'Street',
            'username'          => 'Name',
        ],
        'index'         => [
            'subtotal'  => 'Subtotal',
        ],
        'list'          => [
            'address_details'   => 'Address Details',
            'block'             => 'Block',
            'mobile'            => 'Mobile',
            'state'             => 'State',
            'street'            => 'Street',
        ],
        'title'         => 'Order Address',
        'validation'    => [
            'address'   => [
                'numeric'   => 'Please select the order address',
                'required'  => 'Please select the order address',
            ],
        ],
    ],
    'addresses' => [
        'form'  => [
            'kuwait'    => 'Kuwait',
        ],
    ],
    'cart'      => [
        'add_succesfully'   => 'Item addesd successfully to shopping cart',
        'btn'               => [
            'continue'              => 'Continue Shopping',
            'got_to_shopping_cart'  => 'Go to shopping cart',
        ],
        'cart_updated'      => 'Your request is done successfully',
        'clear'             => 'Clear all',
        'clear_cart'        => 'Cart cleared successfully',
        'delete_item'       => 'Product deleted from cart',
        'empty'             => 'There is no products in your shopping cart',
        'error_in_cart'     => 'Opss! , please try again please.',
        'go_to_checkout'    => 'Continue Order',
        'shipping'          => 'Shipping',
        'subtotal'          => 'Subtotal',
        'title'             => 'Shopping Cart',
        'total'             => 'Total',
    ],
    'checkout'  => [
        'address'           => [
            'btn'       => [
                'add'       => 'Add address',
                'add_modal' => 'Add New Address',
            ],
            'details'   => [
                'address'   => 'Address Details',
                'block'     => 'Block',
                'mobile'    => 'Mobile',
                'state'     => 'State',
                'street'    => 'Street',
            ],
            'form'      => [
                'address_details'   => 'Address Details',
                'block'             => 'Block Number',
                'building'          => 'Building Number',
                'email'             => 'E-mail address',
                'mobile'            => 'Mobile',
                'states'            => 'Choose State',
                'street'            => 'Street',
                'username'          => 'Name',
            ],
            'title'     => 'Order Address',
        ],
        'coupon_discount'   => 'Coupon',
        'delivery_message'  => 'Given the current conditions, the order\'s delivery will be within 48 hours',
        'form'              => [
            'date'  => 'Chose Date',
            'time'  => 'Delivery Time',
            'time_from'  => 'From',
            'time_to'  => 'To',
        ],
        'index'             => [
            'go_to_payment' => 'Make Order Now',
            'payments'      => 'Choose Payment',
            'title'         => 'Checkout',
        ],
        'shipping'          => 'Shipping',
        'subtotal'          => 'Subtotal',
        'title'             => 'Checkout',
        'total'             => 'Total',
        'validation'        => [
            'order_limit'   => 'Sorry you can not continue for check out from this vendor , you must choose products not less than :',
        ],
    ],
    'favorites' => [
        'add_succesfully'   => 'Added successfully to favorite list',
        'btn'               => [
            'continue'              => 'Continue',
            'got_to_favorite_list'  => 'Go to favorite list',
        ],
        'clear'             => 'Clear',
        'title'             => 'Favorite List',
    ],
    'products'  => [
        'add_notes' => 'Add Note',
        'notes'     => 'Note',
        'alerts'            => [
            'product_qty_less_zero' => 'Sorry this product is out of stock , try again later',
            'qty_is_not_active'     => 'Product is not available now.',
            'qty_more_than_max'     => 'Sorry , but you can not request more than :',
            'time_date_not_accepted' => 'We can\'t accepted your order in this time selection , please change date or time.',
            'vendor_not_match'      => 'You can not add this item before clear the cart of another vendor.',
        ],
        'description'       => 'Description of product',
        'form'              => [
            'option'    => 'Select Option',
        ],
        'price'             => 'Product Price',
        'related_products'  => 'Related Products',
        'sku'               => 'SKU',
        'validation'        => [
            'option_value'  => [
                'required'  => 'Please select',
            ],
            'qty'           => [
                'numeric'   => 'Please enter quantity with numeric only',
                'required'  => 'Please enter quantity of product',
            ],
        ],
    ],
    'search'    => [
        'index' => [
            'empty' => 'There is no products or vendor with your search key',
            'title' => 'Search Result',
        ],
    ],
];

<?php

return [
    'order_statuses' => [
        'datatable' => [
            'color_label' => 'Label Color',
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'failed_status' => 'Failed Order Status',
            'label_color' => 'Label Color',
            'options' => 'Options',
            'success_status' => 'Success Order Status',
            'title' => 'Title',
        ],
        'form' => [
            'color_label' => 'Label Color',
            'failed_status' => 'Failed Order Status',
            'label_color' => 'Label Color',
            'success_status' => 'Success Order Status',
            'tabs' => [
                'general' => 'General Info.',
            ],
            'title' => 'Title',
        ],
        'routes' => [
            'create' => 'Create Order Statuses',
            'index' => 'Order Statuses',
            'update' => 'Update Order Statuses',
        ],
        'validation' => [
            'color_label' => [
                'required' => 'Please enter the color of label for this status',
            ],
            'label_color' => [
                'required' => 'Please enter the color of label for this status',
            ],
            'title' => [
                'required' => 'Please enter the title of order status',
                'unique' => 'This title order status is taken before',
            ],
        ],
    ],
    'orders' => [
        'datatable' => [
            'created_at' => 'Created At',
            'date_range' => 'Search By Dates',
            'driver' => 'Driver',
            'method' => 'Payment Method',
            'options' => 'Options',
            'shipping' => 'Delivery',
            'status' => 'Order Status',
            'subtotal' => 'Subtotal',
            'time' => 'Delivery Time',
            'total' => 'Total',
            'total_profit_comission' => 'Commissions',
            'vendor_id' => 'Vendor',
            'delivery_status' => 'Delivery Status',
        ],
        'emails' => [
            'drivers' => [
                'subject' => 'New Order',
            ],
        ],
        'index' => [
            'statistics' => [
                'canceled_orders' => 'Total canceled orders',
                'failed_orders' => 'Total failed ordesr',
                'returned_orders' => 'Total returned orders',
                'success_orders' => 'Total success orders',
            ],
            'title' => 'Orders',
        ],
        'reports' => [
            'title' => 'Orders Reports',
        ],
        'show' => [
            'address' => [
                'block' => 'Block',
                'building' => 'Building',
                'city' => 'City',
                'data' => 'Address info.',
                'details' => 'Details',
                'state' => 'State',
                'street' => 'Street',
            ],
            'drivers' => [
                'title' => 'Drivers',
                'assign' => 'Assign to driver',
                'no_drivers' => 'There are currently no drivers',
                'status' => 'Order Status',
                'delivery_status' => 'Delivery Status',
                'time' => 'Delivery Time',
                'change_order_status' => 'Change Order Status',
            ],
            'payment' => [
                'title' => 'Payment Method',
            ],
            'edit' => 'Edit Order Status',
            'invoice' => 'Invoice',
            'invoice_customer' => 'Customer Invoice',
            'invoice_vendor' => 'Vendor Invoice',
            'notes' => 'Vendor Notes',
            'user_notes' => 'Client Notes',
            'items' => [
                'data' => 'Items',
                'off' => 'off',
                'options' => 'Options',
                'price' => 'Price',
                'qty' => 'Qty',
                'title' => 'Title',
                'total' => 'Total',
            ],
            'order' => [
                'data' => 'Order info.',
                'delivery_time' => 'Delivery Time',
                'off' => 'Discount',
                'shipping' => 'Delivery',
                'subtotal' => 'Subtotal',
                'total' => 'Total',
            ],
            'other' => [
                'data' => 'Order Additional info.',
                'total_comission' => 'Commission from vendor',
                'total_profit' => 'Cost Price Profit',
                'total_profit_comission' => 'Total Profit',
                'vendor' => 'Vendor',
            ],
            'title' => 'Show Order',
            'user' => [
                'data' => 'Customer Info.',
                'email' => 'Email',
                'mobile' => 'Mobile',
                'username' => 'Username',
            ],
        ],
        'success' => [
            'statistics' => [
                'canceled_orders' => 'Total canceled orders',
                'failed_orders' => 'Total failed ordesr',
                'returned_orders' => 'Total returned orders',
                'success_orders' => 'Total success orders',
            ],
            'title' => 'Success Orders',
        ],
    ],
    'order_drivers' => [
        'qty_is_not_available_for_product' => 'Quantity is not available for product',
        'product_not_found' => 'Product is not available currently',
        'validation' => [
            'user_id' => [
                'required' => 'Please, select driver',
                'exists' => 'This driver is not found now',
            ],
            'order_status' => [
                'required' => 'Please, select order status',
                'exists' => 'Order status is not found now',
            ],
            'payment_method' => [
                'required' => 'Please, select payment method',
                'exists' => 'Payment method is not found now',
            ],
        ],
    ],
];

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Billing route
    |--------------------------------------------------------------------------
    |
    | The route to the billing page where the Chip components are. The
    | user will be redirected here after billing actions have been completed.
    |
    */

    'billing_route' => env('CHIP_BILLING_ROUTE', '/billing'),

    /*
    |--------------------------------------------------------------------------
    | Plans
    |--------------------------------------------------------------------------
    |
    | These plans should represent the plans you have defined in Stripe.
    |
    */

    'plans' => [
        [
            'id'       => 'product-9-monthly',
            'name'     => 'Freelancer',
            'price'    => 9,
            'interval' => 'monthly',
            'features' => ['1 user'],
        ],
        [
            'id'       => 'product-29-monthly',
            'name'     => 'Small Team',
            'price'    => 29,
            'interval' => 'monthly',
            'features' => ['5 users'],
        ],
        [
            'id'       => 'product-59-monthly',
            'name'     => 'Big Team',
            'price'    => 59,
            'interval' => 'monthly',
            'features' => ['15 users'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | Tweak which currency is displayed in the Chip components.
    |
    */

    'currency' => [
        'symbol' => env('CHIP_CURRENCY_SYMBOL', '$'),
        'code'   => env('CHIP_CURRENCY_CODE', 'USD'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Billing Address
    |--------------------------------------------------------------------------
    |
    | Your company billing address. Used in invoices.
    |
    */

    'billing_address' => [
        'name'           => '',
        'address_line_1' => '',
        'address_line_2' => '',
        'city'           => '',
        'state'          => '',
        'country'        => '',
        'zip'            => '',
        'phone'          => '',
        'url'            => '',
        'vat'            => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Listeners
    |--------------------------------------------------------------------------
    |
    | Register Chip specific event listeners. Override these if you want to
    | disable them or specify your own listeners.
    |
    */

    'listeners' => [
        'Dev7studios\Chip\Laravel\Events\InvoicePaymentSucceeded' => [
            'Dev7studios\Chip\Laravel\Listeners\SendInvoicePaidNotification',
        ],
    ],
];

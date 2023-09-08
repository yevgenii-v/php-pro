<?php

    return [
        'paypal' => [
            'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
            'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
            'app_id' => env('PAYPAL_APP_ID', ''),
            'mode' => env('PAYPAL_MODE', ''),
        ],
        'stripe' => [
            'secret_key' => env('STRIPE_SECRET_KEY'),
            'publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
        ],
        'liqpay' => [
            'private_key' => env('LIQPAY_PRIVATE_KEY'),
            'public_key' => env('LIQPAY_PUBLIC_KEY'),
        ],
    ];

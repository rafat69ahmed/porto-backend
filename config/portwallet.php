<?php

return [
    'redirect_url' => env('PORTWALLET_REDIRECT_URL'),
    'ipn_url' => env('PORTWALLET_IPN_URL'),
    'endpoints' => [
        'create_invoice' => env('PORTWALLET_CREATE_INVOICE_ENDPOINT', 'https://api-sandbox.portwallet.com/payment/v2/invoice'),
    ],
    'credentials' => [
        'app_key' => env('PORTWALLET_APP_KEY'),
        'secret_key' => env('PORTWALLET_SECRET_KEY'),
        'token' => base64_encode(env('PORTWALLET_APP_KEY').':'.md5(env('PORTWALLET_SECRET_KEY').time())),
    ],
];

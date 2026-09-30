<?php

return [
    /*
    |--------------------------------------------------------------------------
    | BuatQris Configuration (buatqris.site)
    |--------------------------------------------------------------------------
    |
    | Open API credentials from https://app.buatqris.site (Menu: Open API)
    | No KTP required. Instant dynamic QRIS generation.
    |
    */

    'account_id' => env('BUATQRIS_ACCOUNT_ID', ''),
    'secret_token' => env('BUATQRIS_SECRET_TOKEN', ''),
    'signing_secret' => env('BUATQRIS_SIGNING_SECRET', ''),
    'base_url' => env('BUATQRIS_BASE_URL', 'https://api.buatqris.site'),
    'umkm_name' => env('BUATQRIS_UMKM_NAME', 'ANDRA JB'),
    'is_test' => (bool) env('BUATQRIS_IS_TEST', false),
];

<?php

return [
    'banks' => [
        'unique_name' => [
            'gateway_class'     =>  \Mews\Pos\Gateways\PayForPos::class, // Required
            'lang'              => 'tr',

            'credentials'       => [
                'payment_model' => \Mews\Pos\PosInterface::MODEL_3D_SECURE,
                'merchant_id'   => env('BK_MERCHANT'), // Üye İşyeri Numarası.
                'user_name'     => env('BK_USER'), // UserCode: Otorizasyon sistemi kullanıcı kodu.
                'user_password' => env('BK_PASS'), // Otorizasyon sistemi kullanıcı şifresi.
                'enc_key'       => env('BK_KEY'), // MerchantPass: 3D Secure şifresidir.
            ],

            'gateway_endpoints' => [
                'payment_api'     => 'https://vpostest.qnbfinansbank.com/Gateway/XMLGate.aspx',
                'gateway_3d'      => 'https://vpostest.qnbfinansbank.com/Gateway/Default.aspx',
                'gateway_3d_host' => 'https://vpostest.qnbfinansbank.com/Gateway/3DHost.aspx',
            ],
            'test_mode'         => env('BK_TEST'),
        ],
    ],
];

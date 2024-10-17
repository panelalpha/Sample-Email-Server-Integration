<?php

return [
    'App\Lib\Integrations\EmailServers\SampleEmailServer' => [
        "title" => "Sample Email Server",
        "description" => "Sample Email Server - Description about Email Server Module",
        "fields" => [
            'api_url' => [
                'label' => 'Url',
            ],
            'api_key' => [
                'label' => 'API Key',
            ],
            'ssl_verification' => [
                'label' => 'SSL Verification',
            ],
        ],
        "config" => [
            'example_config' => [
                'label' => 'Example Config',
            ]
        ]
    ]
];
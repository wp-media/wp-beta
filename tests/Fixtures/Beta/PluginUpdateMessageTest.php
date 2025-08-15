<?php

return [
    'testShouldDoNothingWhenBetaNotEnabled' => [
        'config' => [
            'optin_enabled' => false,
            'data' => [
                'is_beta' => true,
            ],
        ],
        'expected' => false,
    ],
    'testShouldDoNothingWhenBetaNotAvailable' => [
        'config' => [
            'optin_enabled' => true,
            'data' => [
                'is_beta' => false,
            ],
        ],
        'expected' => false,
    ],
    'testShouldOutputBetaMessageWhenEnabled' => [
        'config' => [
            'optin_enabled' => true,
            'data' => [
                'is_beta' => true,
            ],
        ],
        'expected' => true,
    ],
];

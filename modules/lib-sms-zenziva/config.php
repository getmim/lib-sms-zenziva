<?php

return [
    '__name' => 'lib-sms-zenziva',
    '__version' => '1.0.0',
    '__git' => 'git@github.com:getmim/lib-sms-zenziva.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-sms-zenziva' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'lib-sms' => null
            ],
            [
                'lib-curl' => null
            ]
        ],
        'optional' => []
    ],
    '__inject' => [
        [
            'name' => 'libSmsZenziva',
            'children' => [
                [
                    'name' => 'userkey',
                    'question' => 'Zenziva API userkey',
                    'rule' => '!^.+$!'
                ],
                [
                    'name' => 'passkey',
                    'question' => 'Zenziva API passkey',
                    'rule' => '!^.+$!'
                ]
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'LibSmsZenziva\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-sms-zenziva/library'
            ]
        ],
        'files' => []
    ],
    'libSms' => [
        'senders' => [
            'zenziva' => 'LibSmsZenziva\\Library\\Sender'
        ]
    ]
];

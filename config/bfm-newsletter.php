<?php

return [
    // Currently only MailChimp supported
    'gateway' => 'MailChimp',
    'apiKey' => env('MAILCHIMP_APIKEY', '9d90ca66ecd3e2f8ec2c871877b48e05-us14'),
    // Default subscriber list
    'defaultListName' => 'my_list',
    // Subscriber list configuration
    'lists' => [
        'my_list' => [
            'id' => env('MAILCHIMP_LISTID', '4f57b5b525')
        ]
    ],
    'authGuard' => null,
    'adminMiddleware' => ['web', 'can:admin-full-access'],
];

<?php

return [
    'entity' => [
        'subscriber' => [
            'singular' => 'Subscriber',
            'plural' => 'Subscribers',
        ],
    ],

    'messages' => [
        'invalid_email' => 'Invalid email address',
        'subscribe_failed' => 'Failed to subscribe. Have you already subscribed?',
        'subscribe_succeeded' => 'You have been subscribed',
        'already_subscribed' => 'You are already a newsletter member',
    ],
    
    'properties' => [
        'email' => 'Email address',
        'list' => 'List'
    ],

    'form' => [
        'labels' => [
            'email' => 'Email address',
        ],
        'placeholders' => [
            'email' => 'Email',
        ],
        'buttons' => [
            'subscribe' => 'Subscribe'
        ],
    ],
];

<?php

use Jenssegers\Agent\Agent;

$agent = new Agent();
$basic_set = ($agent->isMobile() || $agent->isTablet()) ? 'f|t|g|p|w' : 'f|t|g|p';

return [
    'social_networks' => [
        'facebook' => [
            'shortcut' => 'f',
            'view' => 'bfm-share::socials.facebook',
            'icon_view' => 'bfm-share::icons.facebook',
        ],
        'twitter' => [
            'shortcut' => 't',
            'view' => 'bfm-share::socials.twitter',
            'icon_view' => 'bfm-share::icons.twitter',
            'via' => 'bfm-share',
            'text' => 'Visit this site',
        ],
        'google' => [
            'shortcut' => 'g',
            'view' => 'bfm-share::socials.google',
            'icon_view' => 'bfm-share::icons.google',
        ],
        'linkedin' => [
            'shortcut' => 'l',
            'view' => 'bfm-share::socials.linkedin',
            'icon_view' => 'bfm-share::icons.linkedin',
        ],
        'pinterest' => [
            'shortcut' => 'p',
            'view' => 'bfm-share::socials.pinterest',
            'icon_view' => 'bfm-share::icons.pinterest'
        ],
        'whatsapp' => [
            'shortcut' => 'w',
            'view' => 'bfm-share::socials.whatsapp',
            'icon_view' => 'bfm-share::icons.whatsapp',
            'subject' => 'Take a look at this awesome website:'
        ],
        'email' => [
            'shortcut' => 'e',
            'view' => 'bfm-share::socials.email',
            'icon_view' => 'bfm-share::icons.email',
            'subject' => 'Visit this site',
            'body' => 'Please visit this site: http://site.com',
        ],
    ],

    'socials_shortcuts_separator' => '|',

    'basic_set' => $basic_set //default f|t|l|g|p|e
];

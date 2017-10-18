<?php

return [
    'url' => 'admin/cms',
    'template' => [
        'layout' => 'vendor/backpack/base/layout',
        'styleSection' => 'cms-styles',
        'contentHeaderSection' => 'header',
        'contentSection' => 'content',
        'scriptSection' => 'cms-scripts',
        'messagesSessionKey' => 'success-message'
    ],
    'pageLayouts' => [
        'Main' => 'layouts.1column',
    ],
    'style' => [
        'customStyles' => false
    ],
    'security' => [
        'middleware' => ['web', 'can:admin-full-access']
    ],
    'templates' => [
        'Bfm\Flex\Cms\Templates\Wysiwyg',
        'Bfm\Flex\Cms\Templates\TwoColumnWysiwyg',
        'Bfm\Flex\Cms\Templates\Tabs',
        'Bfm\Flex\Cms\Templates\Gallery',
        'Bfm\Flex\Cms\Templates\Slider',
        'Bfm\Flex\Cms\Templates\Faq',
    ],
    'image_sizes' => [
        'gallery_item' => 'gallery_item',
        'slider_item' => 'slider_item',
        'tabs_item' => 'tabs_item'
    ],
    'tabs_items_has_image' => false,
    'tabs_items_has_button' => false
];

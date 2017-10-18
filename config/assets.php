<?php

return [
    'default' => [],
    'adminlte' => [
        'public_dir' => (function_exists('public_path')) ? public_path() : '',
        'css_dir' => '/vendor/adminlte',
        'js_dir' => '/vendor/adminlte',
        'pipeline' => env('APP_ASSETS_PIPELINE', false),
        'pipeline_dir' => '../min',
        'pipeline_gzip' => false,
        'css_minifier' => function ($buffer) {
            return $buffer;
        },
        'collections' => [
            'jquery' => 'plugins/jQuery/jquery-2.2.3.min.js',
            'bootstrap' => [
                'bootstrap/css/bootstrap.min.css',
                'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
                'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
                'bootstrap/js/bootstrap.min.js'
            ],
            'pace' => [
                'plugins/pace/pace.min.css',
                'plugins/pace/pace.min.js'
            ],
            'plugins' => [
                'plugins/iCheck/flat/blue.css',
                'plugins/morris/morris.css',
                'plugins/jvectormap/jquery-jvectormap-1.2.2.css',
                'plugins/datepicker/datepicker3.css',
                'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
                'pace',
                'plugins/slimScroll/jquery.slimscroll.min.js',
                'plugins/fastclick/fastclick.js'
            ],
            'dist' => [
                'dist/css/AdminLTE.min.css',
                'dist/css/skins/_all-skins.min.css',
                'dist/js/app.min.js'
            ],
            // do not autoload collections below - they aren't global
            'jqueryUI' => [
                'https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css',
                'plugins/jQueryUI/jquery-ui.min.js'
            ],
            'datatables' => [
                'plugins/datatables/dataTables.bootstrap.css',
                'plugins/datatables/jquery.dataTables.js',
                'plugins/datatables/dataTables.bootstrap.js'
            ]
        ],
        'autoload' => [
            'jquery',
            'bootstrap',
            'plugins',
            'dist',
            'layout.js'
        ],
    ],
    'backpack' => [
        'public_dir' => (function_exists('public_path')) ? public_path() : '',
        'css_dir' => '/vendor/backpack',
        'js_dir' => '/vendor/backpack',
        'pipeline' => env('APP_ASSETS_PIPELINE', false),
        'pipeline_dir' => '../min',
        'pipeline_gzip' => false,
        'css_minifier' => function ($buffer) {
            return $buffer;
        },
        'collections' => [
            'base' => [
                'backpack.base.css',
                'backpack.override.css'
            ],
            'pnotify' => [
                'pnotify/pnotify.custom.min.css',
                'pnotify/pnotify.custom.min.js'
            ],
            // do not autoload collections below - they aren't global
            'pikaday' => [
                'moment' => ['moment/moment.min.js'],
                'pikaday/pikaday.js',
                'pikaday/pikaday.jquery.js',
                'pikaday/pikaday.css',
                'pikaday/theme.css'
            ],
            'cropper' => [
                'cropper/dist/cropper.min.css',
                'cropper/dist/cropper.min.js',
            ],
            'colorbox' => [
                'colorbox/example2/colorbox.css',
                'colorbox/jquery.colorbox-min.js',
            ],
            'select2' => [
                'select2/select2.css',
                'select2/select2-bootstrap-dick.css',
                'select2/select2.min.js'
            ],
            'ckeditor' => [
                'ckeditor/ckeditor.js',
                'ckeditor/adapters/jquery.js'
            ],
            'tinymce' => [
                'tinymce/tinymce.min.js'
            ],
            'summernote' => [
                'summernote/summernote.css',
                'summernote/summernote.min.js'
            ],
            'nestedSortable' => [
                'nestedSortable/nestedSortable.css',
                'nestedSortable/jquery.mjs.nestedSortable2.js'
            ],
            'elfinder' => [
                'elfinder/elfinder.backpack.theme.css'
            ]
        ],
        'autoload' => [
            'base',
            'pnotify'
        ],
    ],
    'barryvdh' => [
        'public_dir' => (function_exists('public_path')) ? public_path() : '',
        'css_dir' => '/packages/barryvdh',
        'js_dir' => '/packages/barryvdh',
        'pipeline' => env('APP_ASSETS_PIPELINE', false),
        'pipeline_dir' => '../min',
        'pipeline_gzip' => false,
        'css_minifier' => function ($buffer) {
            return $buffer;
        },
        'collections' => [
            'elfinder' => [
                'elfinder/css/elfinder.min.css',
                'elfinder/js/elfinder.min.js'
            ]
        ],
        'autoload' => [],
    ],
    'ie9' => [
        'public_dir' => (function_exists('public_path')) ? public_path() : '',
        'css_dir' => '/vendor/ie9',
        'js_dir' => '/vendor/ie9',
        'pipeline' => env('APP_ASSETS_PIPELINE', false),
        'pipeline_dir' => '../min',
        'pipeline_gzip' => false,
        'css_minifier' => function ($buffer) {
            return $buffer;
        },
        'collections' => [],
        'autoload' => [
            'html5shiv.min.js',
            'respond.min.js'
        ],
    ],
    'frontend' => [
        'public_dir' => (function_exists('public_path')) ? public_path() : '',
        'css_dir' => '/css',
        'js_dir' => '/js',
        'pipeline' => env('APP_ASSETS_PIPELINE', false),
        'pipeline_dir' => '../min',
        'pipeline_gzip' => false,
        'css_minifier' => function ($buffer) {
            return $buffer;
        },
        'collections' => [
            'base' => [
                'libs.js',
                'app.js',
                'main.js',
                'print.js',
                'share.js',
                'community.js'
            ],
            'footer' => [
                ''
            ],
            'header' => [
                ''
            ],
            'external' => [
                ''
            ],
        ],
        'autoload' => [
            'base'
        ],
    ]
];

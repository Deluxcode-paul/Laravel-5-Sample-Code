const Elixir = require('laravel-elixir');
const config = require('laravel-elixir-config');

var argv = require('yargs').argv;

require('laravel-elixir-vue');

require('./elixir-custom-tasks');

Elixir.config.browserSync.open = 'external';
Elixir.config.css.autoprefix.options.browsers = [
    "last 2 versions",
    "iOS >= 7",
    "Android >= 5",
    "IE >= 11"
];

Elixir(mix => {

    if (argv.svgsprite) {
        mix.svgsprite();
        return;
    }

    if (argv.vendors) {

        // Copy vendor CSS to the project
        mix.styles([
            'node_modules/alertifyjs/build/css/alertify.css',
            'node_modules/alertifyjs/build/css/themes/default.css',
            'node_modules/select2/dist/css/select2.min.css',
            'node_modules/magnific-popup/dist/magnific-popup.css',
            'node_modules/responsive-tabs/css/responsive-tabs.css',
            'node_modules/swiper/dist/css/swiper.min.css'
        ], Elixir.config.assetsPath + '/' + Elixir.config.css.sass.folder + '/vendors/_npm-vendors.css', './');

        // Render libs.js with vendor plugins/libs
        mix.webpack('libs.js');

    }

    mix.sass('general.scss');
    mix.sass('pdf.scss');
    mix.webpack('main.js');
    mix.webpack('app.js');

    if (argv.production) {
        mix.version([
            'public/js/libs.js',
            'public/js/main.js',
            'public/js/app.js',
            'public/css/general.css',
            'public/css/pdf.css'
        ]);
    }

});
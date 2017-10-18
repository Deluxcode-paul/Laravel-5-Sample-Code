const Elixir = require('laravel-elixir');
const config = require('laravel-elixir-config');

var Task = Elixir.Task;

var gulp = require('gulp'),
    filelog = require('gulp-filelog'),
    inject = require('gulp-inject'),
    cheerio = require('gulp-cheerio'),
    svgmin = require('gulp-svgmin'),
    svgstore = require('gulp-svgstore');

Elixir.config.svg = {
    src: '/images/svg-sprite',
    outputPath: '/partials/svg-sprite.blade.php'
};

Elixir.extend('svgsprite', (src, outputPath, options) => {
    new Elixir.Task('svgsprite', () => {

        function fileContents(filePath, file){
            return file.contents.toString();
        }

        src = Elixir.config.assetsPath + (src || Elixir.config.svg.src);
        outputPath = Elixir.config.viewPath + (outputPath || Elixir.config.svg.outputPath);

        options = Object.assign({}, options);

        var svgs = gulp
            .src(src + '/*.svg')
            .pipe(filelog())
            .pipe(cheerio({
                run: ($) => {
                    $('[opacity]').removeAttr('opacity');
                },
                parserOptions: {xmlMode: true}
            }))
            .pipe(svgmin())
            .pipe(svgstore({
                inlineSvg: true,
                viewBox: '0 0 100 100',
                xmlns: 'http://www.w3.org/2000/svg'
            }));

        return gulp
            .src(outputPath, {base: './'})
            .pipe(inject(svgs, {transform: (filePath, file) => file.contents.toString()}))
            .pipe(gulp.dest('./'));
    });
});
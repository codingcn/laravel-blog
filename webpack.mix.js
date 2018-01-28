let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/home/js/app.js', 'public/static/home/js')
    .js('resources/assets/admin/js/app.js', 'public/static/admin/js')
    .sass('resources/assets/home/sass/github-markdown.scss', 'public/static/lib/github-markdown/github-markdown.css')
    .sass('resources/assets/home/sass/font-awesome.scss', 'public/static/lib/font-awesome/css/font-awesome.css')
    .copyDirectory('node_modules/font-awesome/fonts', 'public/static/lib/font-awesome/fonts') //为了能在二级目录使用laravel
    .sass('resources/assets/home/sass/app.scss', 'public/static/home/css')
    .options({
        processCssUrls: false //为了能在二级目录使用laravel
    });

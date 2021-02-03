const mix = require('laravel-mix');

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

mix.styles(['node_modules/bootstrap/dist/css/bootstrap.min.css', 'node_modules/swiper/css/swiper.min.css'], 'public/css/vendor.css')// load 3th party css
    .js('resources/js/vendor.js', 'public/js')//load al 3th party plugins and packages
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/filters.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css/admin')
    .copyDirectory('resources/assets/images', 'public/images')
    .options({ processCssUrls: true })
    .version('public/images');

const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 | .services('resources/services/main.services', 'public/services')
 */

mix.js('resources/services/main.services', 'public/services/main.services')
    .sass('resources/sass/app.scss', 'public/css/app.css');

mix.js('resources/services/admin.services', 'public/services/admin.services')
    .sass('resources/sass/admin.scss', 'public/css/admin.css');

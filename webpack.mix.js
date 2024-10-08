const mix = require('laravel-mix');
require('dotenv').config();
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

 mix.react('resources/js/index.jsx', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .styles(['public/assets/css/styles.css'], 'public/assets/css/styles.min.css')
   ;


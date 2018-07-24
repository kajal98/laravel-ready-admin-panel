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

mix.scripts([
	'resources/assets/js/jquery.min.js',
	'resources/assets/js/script.js',
	'resources/assets/js/plupload.full.min.js',
	'resources/assets/js/delete.js',
	], 'public/js/admin.js');
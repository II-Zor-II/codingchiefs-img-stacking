/**
 * @version : laravel-mix 6.0.27
 * @docs : https://laravel-mix.com/docs/6.0/what-is-mix
 *
 */
const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js('resources/js/app.js', 'public/js')
    .vue({version: 2})
    .extract(['vue'])
    .copy('resources/img/*', 'public/img');

mix.sass('resources/sass/app.scss', 'public/css');

mix.browserSync({
    proxy: 'localhost',
    open: false,
});

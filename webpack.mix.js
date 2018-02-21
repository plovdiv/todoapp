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

// Bootstrap's JavaScript requires jQuery
mix.autoload({
    'jquery': ['window.$', 'window.jQuery', '$', 'jQuery']
});

mix.browserSync({
    host: 'todoapp.local',
    proxy: 'todoapp.com', //if there is already created domain
});

mix.setPublicPath('public/dist');
mix.setResourceRoot('../'); // fix for fonts

mix.js('resources/assets/js/app.js', 'js')
        .sass('resources/assets/sass/app.scss', 'css');

if (mix.config.production) {
    mix.version();
}


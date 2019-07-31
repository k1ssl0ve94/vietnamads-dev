let mix = require('laravel-mix');

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    vue: ['Vue', 'window.Vue'],
    moment: ['moment', 'window.moment']
});

mix
    .setPublicPath(path.normalize('public'))
    .js('resources/assets/frontend/js/app.js', 'public/js')
    .extract(['vue', 'jquery', 'axios', 'lodash', 'bootstrap', 'popper.js']);
mix.sass('resources/assets/frontend/sass/app.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}

mix.disableNotifications();
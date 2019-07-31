let mix = require('laravel-mix');

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    vue: ['Vue', 'window.Vue'],
    moment: ['moment', 'window.moment']
});

mix
    .setPublicPath(path.normalize('public/backend'))
    .js('resources/assets/backend/js/app.js', 'public/backend/js')
    .extract(['vue', 'jquery', 'axios', 'lodash', 'chart.js', 'bootstrap', 'popper.js']);
mix.sass('resources/assets/backend/sass/app.scss', 'public/backend/css');

if (mix.inProduction()) {
    mix.version();
}

mix.disableNotifications();
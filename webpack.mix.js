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

let configDev = {
    url : 'maildran.app',
    port: 443
};

mix.browserSync({
    proxy: {
        target: 'https://' + configDev.url + ':3000',
        reqHeaders: function() {
            return {
                host: configDev.url,
            };
        },
        proxyReq: [
            function(proxyReq) {
                proxyReq.setHeader('HOST', configDev.url);
            }
        ]
    },
    https: true,
    port: configDev.port
});

mix.js('resources/assets/js/app.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');

if (mix.inProduction()) {
    mix.version();
}

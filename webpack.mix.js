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

mix.js('resources/site/js/app.js', 'public/site/js')
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/site/js'),
                '@assets': path.resolve(__dirname, 'resources/site/assets'),
                '@sass': path.resolve(__dirname, 'resources/site/sass'),
                '@plugin': path.resolve(__dirname, 'resources/js/plugins'),
            }
        }
    })
    .sass('resources/site/sass/app.scss', 'public/site/css')
    .copy('resources/site/assets', 'public/site/assets');

if (mix.inProduction()) {
    mix.version();
    mix.webpackConfig({
        output: {
            chunkFilename: 'site/js/chunks/[name].[chunkhash].js',
        }
    });
}
else{
    mix.webpackConfig({
        output: {
            chunkFilename: 'site/js/chunks/[name].js',
        }
    });
}

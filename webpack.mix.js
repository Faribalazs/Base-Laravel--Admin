const mix = require('laravel-mix');
mix.sass('resources/sass/app.scss', 'css');
const webpack = require('webpack');

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

mix.js('resources/js/app.js', 'public/js').js('resources/js/vue.js', 'public/js').vue().postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
])
.sourceMaps();

mix.copyDirectory('vendor/tinymce/tinymce', 'public/js/tinymce');

mix.webpackConfig({
    plugins: [
        new webpack.DefinePlugin({
            '__VUE_PROD_DEVTOOLS__': 'false',
            '__VUE_PROD_HYDRATION_MISMATCH_DETAILS__': 'false'
        })
    ]
});
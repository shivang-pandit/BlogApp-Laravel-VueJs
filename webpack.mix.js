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

mix.js([
        'resources/js/app.js',
        'resources/js/frontend/assests/js/jquery-1.12.4.min.js',
        'resources/js/frontend/assests/js/main.js', 
        'resources/js/frontend/assests/js/owl.carousel.min.js', 
      ], 'public/js')
   .styles([       
       'resources/css/main.css',
       'resources/css/grid.min.css',
    ],'public/css/all.css').version()
    .styles([       
      'resources/js/frontend/assests/css/bootstrap.min.css',
      'resources/js/frontend/assests/css/owl.carousel.min.css',
      'resources/js/frontend/assests/css/common.css',
      'resources/js/frontend/assests/css/main.css',
      'resources/js/frontend/assests/css/responsive.css',
   ],'public/css/front-all.css').version();
    // .sass('resources/sass/app.scss', 'public/css');

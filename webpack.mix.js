let mix = require('laravel-mix');
let bootstrapPath = 'node_modules/bootstrap-sass/assets/fonts';
let fontAwesomePath = 'node_modules/font-awesome/fonts';

mix
  .js('resources/assets/js/app.js', 'public/js')
  .sass('resources/assets/sass/app.scss', 'public/css')
  .copy(bootstrapPath, 'public/fonts')
  .copy(fontAwesomePath, 'public/build/fonts')
  .version();

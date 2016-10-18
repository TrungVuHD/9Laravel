var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    var bootstrapPath = 'node_modules/bootstrap-sass/assets';
    var bootstrapPath = '';
    var jsFiles = [ 
        '../../../node_modules/jquery/dist/jquery.min.js',
        '../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'resources/assets/js/libraries/FileDrop-master/filedrop-min.js',
        '../../../node_modules/mustache/mustache.min.js',
        'resources/assets/js/*.js'
    ]; 

    mix
    //compile the scss
    .sass('app.scss')
    //compile the js
    .scripts(jsFiles, 'public/js/scripts.min.js')
    //copy the fonts
    .copy(bootstrapPath + '/fonts', 'public/fonts')
    //version(cache bust) the build files
    .version([ 'css/app.css', 'js/scripts.min.js']);

});
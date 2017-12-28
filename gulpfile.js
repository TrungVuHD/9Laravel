var elixir = require('laravel-elixir');

elixir(function(mix) {
  "use strict";

  var nodePath = '../../../node_modules/';
  var bootstrapPath = 'node_modules/bootstrap-sass/assets/fonts';
  var fontAwesomePath = 'node_modules/font-awesome/fonts';
  var jsFiles = [
    nodePath + 'jquery/dist/jquery.min.js',
    nodePath + 'bootstrap-sass/assets/javascripts/bootstrap.min.js',
    nodePath + 'mustache/mustache.min.js',
    nodePath + 'filedrop/filedrop.js',
    'resources/assets/js/*.js'
  ];

  mix
    .sass('app.scss')
    .scripts(jsFiles, 'public/js/scripts.min.js')
    .copy(bootstrapPath, 'public/fonts')
    .copy(fontAwesomePath, 'public/build/fonts')
    .version([ 'css/app.css', 'js/scripts.min.js']);
});

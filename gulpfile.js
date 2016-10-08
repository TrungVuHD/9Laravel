var elixir = require('laravel-elixir');
var gulp = require('gulp');
var concat = require('gulp-concat');  
var rename = require('gulp-rename');  
var uglify = require('gulp-uglify');  

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

var jsFiles = [ 
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
    'resources/assets/js/libraries/FileDrop-master/filedrop-min.js',
    'resources/assets/js/*.js'
]; 

var jsDest = 'public/js';

gulp.task('min-scripts', function() {  
    return gulp.src(jsFiles)
		.pipe(concat('scripts.js'))
		.pipe(gulp.dest(jsDest))
		.pipe(rename('scripts.min.js'))
		//.pipe(uglify())
		.pipe(gulp.dest(jsDest));
});

elixir(function(mix) {

	var bootstrapPath = 'node_modules/bootstrap-sass/assets/';

    mix.sass('app.scss')
    	.copy(bootstrapPath + '/fonts', 'public/fonts');

    //minify the js
    mix.task('min-scripts');

    //version the css and js
    mix.version([ 'css/app.css', 'js/scripts.min.js']);
});


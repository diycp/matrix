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

elixir(function (mix) {
    mix.task('browserify', 'resources/assets/js/app/**/*.js');
    mix.sass('app.scss')
        .browserify('app.js')
        .styles(
            [
                'AdminLTE/bootstrap/css/bootstrap.css',
                'AdminLTE/plugins/datatables/dataTables.bootstrap.css',
                'AdminLTE/dist/css/AdminLTE.css',
                'AdminLTE/dist/css/skins/_all-skins.css',
                'font-awesome/css/font-awesome.css',
                'Ionicons/css/ionicons.css',
                'toastr/toastr.css'
            ],
            'public/css/core.css',
            'bower_components'
        )
        .scripts(
            [
                'jquery/dist/jquery.js',
                'angular/angular.js',
                'angular-resource/angular-resource.js',
                'angular-animate/angular-animate.js',
                'angular-cookies/angular-cookies.js',
                'angular-sanitize/angular-sanitize.js',
                'angular-ui-router/release/angular-ui-router.js',
                'angular-ui-validate/dist/validate.js',
                'angular-fullscreen/src/angular-fullscreen.js',
                'marked/lib/marked.js',
                'angular-marked/dist/angular-marked.js',
                'AdminLTE/bootstrap/js/bootstrap.js',
                'AdminLTE/plugins/slimScroll/jquery.slimscroll.js',
                'AdminLTE/plugins/datatables/jquery.dataTables.js',
                'AdminLTE/plugins/datatables/dataTables.bootstrap.js',
                'AdminLTE/dist/js/app.js',
                'angular-datatables/dist/angular-datatables.js',
                'toastr/toastr.js'
            ],
            'public/js/core.js',
            'bower_components'
        )
        .copy(
            [
                'bower_components/AdminLTE/bootstrap/fonts',
                'bower_components/font-awesome/fonts',
                'bower_components/Ionicons/fonts'
            ],
            'public/fonts'
        )
        .copy('bower_components/AdminLTE/dist/img', 'public/img')
        .version(
            [
                'css/core.css',
                'css/app.css',
                'js/core.js',
                'js/app.js'
            ]
        )
        .copy(
            'public/fonts',
            'public/build/fonts'
        );
});

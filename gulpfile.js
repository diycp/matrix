var elixir = require('laravel-elixir');
var fs = require('fs');

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

// 处理插件
var plugins = {
    'css': [
        'resources/assets/css/plugin.css'
    ],
    'js': [
        'resources/assets/js/plugin.js'
    ]
};
var installed = require('./vendor/composer/installed.json');
for (var i in installed) {
    var plugin = installed[i];
    if (plugin['type'] != 'matrix-plugin') continue;

    var path = 'vendor/' + plugin['name'] + '/assets/';
    if (fs.existsSync(path + 'plugin.css')) plugins['css'].push(path + 'plugin.css');
    if (fs.existsSync(path + 'plugin.js')) plugins['js'].push(path + 'plugin.js');
}

elixir(function (mix) {
    mix.task('browserify', 'resources/assets/js/app/**/*.js');
    mix.sass('app.scss')
        .browserify('app.js')
        .styles(
            [
                'AdminLTE/bootstrap/css/bootstrap.css',
                'AdminLTE/dist/css/AdminLTE.css',
                'AdminLTE/dist/css/skins/_all-skins.css',
                'font-awesome/css/font-awesome.css',
                'Ionicons/css/ionicons.css',
                'toastr/toastr.css',
                'angular-material/angular-material.css',
                'angular-material-data-table/dist/md-data-table.css',
                'jquery-confirm2/css/jquery-confirm.css'
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
                'angular-aria/angular-aria.js',
                'angular-ui-router/release/angular-ui-router.js',
                'angular-ui-validate/dist/validate.js',
                'angular-fullscreen/src/angular-fullscreen.js',
                'angular-material/angular-material.js',
                'angular-material-data-table/dist/md-data-table.js',
                'marked/lib/marked.js',
                'angular-marked/dist/angular-marked.js',
                'AdminLTE/bootstrap/js/bootstrap.js',
                'AdminLTE/plugins/slimScroll/jquery.slimscroll.js',
                'AdminLTE/dist/js/app.js',
                'toastr/toastr.js',
                'jquery-confirm2/js/jquery-confirm.js'
            ],
            'public/js/core.js',
            'bower_components'
        )
        .styles(plugins.css, 'public/css/plugin.css', './')
        .scripts(plugins.js, 'public/js/plugin.es5.js', './')
        .browserify('../../../public/js/plugin.es5.js', 'public/js/plugin.js')
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
                'css/plugin.css',
                'js/core.js',
                'js/app.js',
                'js/plugin.js'
            ]
        )
        .copy(
            'public/fonts',
            'public/build/fonts'
        );
});
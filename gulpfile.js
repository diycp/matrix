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
    'scss': [
        'plugin.scss'
    ],
    'js': [
        'plugin.js'
    ],
    'img': [],
    'fonts': []
};
var installed = require('./vendor/composer/installed.json');
for (var i in installed) {
    var plugin = installed[i];
    if (plugin['type'] != 'matrix-plugin') continue;

    var path = 'vendor/' + plugin['name'] + '/';
    var prefix = '../../../';

    if (fs.existsSync(path + 'assets/plugin.scss')) plugins['scss'].push(prefix + path + 'assets/plugin.scss');
    if (fs.existsSync(path + 'assets/plugin.js')) plugins['js'].push(prefix + path + 'assets/plugin.js');
    if (fs.existsSync(path + 'assets/img')) plugins['img'].push(path + 'assets/img');
    if (fs.existsSync(path + 'assets/fonts')) plugins['fonts'].push(path + 'assets/fonts');
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
                'es6-shim/es6-shim.js',
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
                'jquery-confirm2/js/jquery-confirm.js',
                'qrcode-generator/js/qrcode.js',
                'qrcode-generator/js/qrcode_UTF8.js',
                'angular-qrcode/angular-qrcode.js'
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
        .sass(plugins.scss, 'public/css/plugin.css')
        .browserify(plugins.js, 'public/js/plugin.js')
        .copy(plugins.img, 'public/img')
        .copy(plugins.fonts, 'public/fonts')
        .styles(
            [
                'core.css',
                'app.css',
                'plugin.css'
            ],
            'public/css/matrix.css',
            'public/css'
        )
        .scripts(
            [
                'core.js',
                'plugin.js',
                'app.js'
            ],
            'public/js/matrix.js',
            'public/js'
        )
        .version(
            [
                'css/matrix.css',
                'js/matrix.js'
            ]
        )
        .copy(
            'public/fonts',
            'public/build/fonts'
        );
});
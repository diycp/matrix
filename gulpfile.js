var elixir = require('laravel-elixir');
var fs = require('fs');
var path = require('path');
var glob = require('glob');

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
var bower_path = 'bower_components/';

// bower扩展任务队列
var bowers = {
    'scripts': [
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
        'AdminLTE/plugins/input-mask/jquery.inputmask.js',
        'AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js',
        'AdminLTE/plugins/input-mask/jquery.inputmask.numeric.extensions.js',
        'AdminLTE/plugins/input-mask/jquery.inputmask.regex.extensions.js',
        'AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js',
        'moment/moment.js',
        'moment/locale/zh-cn.js',
        'AdminLTE/plugins/daterangepicker/daterangepicker.js',
        'AdminLTE/plugins/datepicker/bootstrap-datepicker.js',
        'AdminLTE/plugins/timepicker/bootstrap-timepicker.js',
        'AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.zh-CN.js',
        'AdminLTE/plugins/select2/select2.full.js',
        'AdminLTE/plugins/colorpicker/bootstrap-colorpicker.js',
        'AdminLTE/dist/js/app.js',
        'toastr/toastr.js',
        'jquery-confirm2/js/jquery-confirm.js',
        'qrcode-generator/js/qrcode.js',
        'qrcode-generator/js/qrcode_UTF8.js',
        'angular-qrcode/angular-qrcode.js'
    ],
    'styles': [
        'AdminLTE/bootstrap/css/bootstrap.css',
        'AdminLTE/dist/css/AdminLTE.css',
        'AdminLTE/dist/css/skins/_all-skins.css',
        'AdminLTE/plugins/daterangepicker/daterangepicker.css',
        'AdminLTE/plugins/timepicker/bootstrap-timepicker.css',
        'AdminLTE/plugins/datepicker/datepicker3.css',
        'AdminLTE/plugins/select2/select2.css',
        'AdminLTE/plugins/colorpicker/bootstrap-colorpicker.css',
        'font-awesome/css/font-awesome.css',
        'Ionicons/css/ionicons.css',
        'toastr/toastr.css',
        'angular-material/angular-material.css',
        'angular-material-data-table/dist/md-data-table.css',
        'jquery-confirm2/css/jquery-confirm.css'
    ],
    'img': [
        'AdminLTE/dist/img',
        'AdminLTE/plugins/colorpicker/img'
    ],
    'fonts': [
        'AdminLTE/bootstrap/fonts',
        'font-awesome/fonts',
        'Ionicons/fonts'
    ]
};

// 插件任务队列
var plugins = {
    'scss': [
        'plugin.scss'
    ],
    'js': [
        'plugin.js'
    ],
    'public': []
};

// 通过composer命令安装
var installed = require('./vendor/composer/installed.json');
for (var i in installed) {
    var plugin = installed[i];
    if (plugin['type'] != 'matrix-plugin') continue;

    var dir = 'vendor/' + plugin['name'] + '/';
    var prefix = '../../../';

    if (fs.existsSync(dir + 'public')) plugins['public'].push(dir + 'public');
    if (fs.existsSync(dir + 'assets/plugin.scss')) plugins['scss'].push(prefix + dir + 'assets/plugin.scss');
    if (fs.existsSync(dir + 'assets/plugin.js')) plugins['js'].push(prefix + dir + 'assets/plugin.js');
}

// 处理本地目录存放的插件
var pluginFiles = glob.sync('matrix/**/composer.json');
for (var i in pluginFiles) {
    var dir = path.dirname(pluginFiles[i]) + '/';
    var prefix = '../../../';

    if (fs.existsSync(dir + 'public')) plugins['public'].push(dir + 'public');
    if (fs.existsSync(dir + 'assets/plugin.scss')) plugins['scss'].push(prefix + dir + 'assets/plugin.scss');
    if (fs.existsSync(dir + 'assets/plugin.js')) plugins['js'].push(prefix + dir + 'assets/plugin.js');
}

// 执行构建任务
elixir(function (mix) {
    // 监听任务
    mix.task('browserify', 'resources/assets/js/app/**/*.js');
    mix.task('browserify', 'matrix/**/assets/**/*.js');
    mix.task('sass', 'matrix/**/assets/**/*.scss');

    // TODO scripts()只能使用一次，否则监听时会进入死循环
    mix.sass('app.scss')
        .browserify('app.js')
        .sass(plugins.scss, 'public/css/plugin.css')
        .browserify(plugins.js, 'public/js/plugin.js')
        .copy(plugins.public, 'public')
        .copy(bowers.fonts.map(path => bower_path + path), 'public/fonts')
        .copy(bowers.img.map(path => bower_path + path), 'public/img')
        .styles(bowers.styles.map(path => '../../' + bower_path + path).concat(['app.css', 'plugin.css']), 'public/css/matrix.css', 'public/css')
        .scripts(bowers.scripts.map(path => '../../' + bower_path + path).concat(['plugin.js', 'app.js']), 'public/js/matrix.js', 'public/js')
        .version(['css/matrix.css', 'js/matrix.js'])
        .copy('public/img', 'public/build/img')
        .copy('public/fonts', 'public/build/fonts');
});
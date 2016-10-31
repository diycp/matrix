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
var npm_path = 'node_modules/';

// npm扩展任务队列
var package = {
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
        'angular-material/angular-material.js',
        'angular-material-data-table/dist/md-data-table.js',
        'marked/lib/marked.js',
        'angular-marked/dist/angular-marked.js',
        'admin-lte/bootstrap/js/bootstrap.js',
        'admin-lte/plugins/slimScroll/jquery.slimscroll.js',
        'admin-lte/plugins/input-mask/jquery.inputmask.js',
        'admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js',
        'admin-lte/plugins/input-mask/jquery.inputmask.numeric.extensions.js',
        'admin-lte/plugins/input-mask/jquery.inputmask.regex.extensions.js',
        'admin-lte/plugins/input-mask/jquery.inputmask.extensions.js',
        'moment/moment.js',
        'moment/locale/zh-cn.js',
        'admin-lte/plugins/daterangepicker/daterangepicker.js',
        'admin-lte/plugins/datepicker/bootstrap-datepicker.js',
        'admin-lte/plugins/timepicker/bootstrap-timepicker.js',
        'admin-lte/plugins/datepicker/locales/bootstrap-datepicker.zh-CN.js',
        'admin-lte/plugins/select2/select2.full.js',
        'admin-lte/plugins/colorpicker/bootstrap-colorpicker.js',
        'admin-lte/dist/js/app.js',
        'toastr/toastr.js',
        'jquery-confirm-npm/js/jquery-confirm.js',
        'qrcode-generator/js/qrcode.js',
        'qrcode-generator/js/qrcode_UTF8.js',
        'angular-qrcode/angular-qrcode.js'
    ],
    'styles': [
        'admin-lte/bootstrap/css/bootstrap.css',
        'admin-lte/dist/css/AdminLTE.css',
        'admin-lte/dist/css/skins/_all-skins.css',
        'admin-lte/plugins/daterangepicker/daterangepicker.css',
        'admin-lte/plugins/timepicker/bootstrap-timepicker.css',
        'admin-lte/plugins/datepicker/datepicker3.css',
        'admin-lte/plugins/select2/select2.css',
        'admin-lte/plugins/colorpicker/bootstrap-colorpicker.css',
        'font-awesome/css/font-awesome.css',
        'ionicons/css/ionicons.css',
        'toastr/build/toastr.css',
        'angular-material/angular-material.css',
        'angular-material-data-table/dist/md-data-table.css',
        'jquery-confirm-npm/css/jquery-confirm.css'
    ],
    'img': [
        'admin-lte/dist/img',
        'admin-lte/plugins/colorpicker/img'
    ],
    'fonts': [
        'admin-lte/bootstrap/fonts',
        'font-awesome/fonts',
        'ionicons/fonts'
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
        .copy(package.fonts.map(path => npm_path + path), 'public/fonts')
        .copy(package.img.map(path => npm_path + path), 'public/img')
        .styles(package.styles.map(path => '../../' + npm_path + path).concat(['app.css', 'plugin.css']), 'public/css/matrix.css', 'public/css')
        .scripts(package.scripts.map(path => '../../' + npm_path + path).concat(['plugin.js', 'app.js']), 'public/js/matrix.js', 'public/js')
        .version(['css/matrix.css', 'js/matrix.js'])
        .copy('public/img', 'public/build/img')
        .copy('public/fonts', 'public/build/fonts');
});
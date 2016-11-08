<?php

use Illuminate\Filesystem\Filesystem;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});

// 插件模块(登录验证需要插件自己调用auth中间件)
$path = app('request')->path();
$route = array_values(array_filter(explode('/', $path)));

if (count($route) >= 2) {
    $group = $route[0];
    $name = $route[1];

    $controller = '\\Matrix\\' . studly_case(strtolower($group)) . '\\' . studly_case(strtolower($name)) . '\\Controller';
    if (class_exists($controller)) {
        // 反解析类
        $object = new \ReflectionClass($controller);
        $pluginPath = dirname(dirname($object->getFileName())); // 插件根目录

        // 获取插件信息
        $plugin = [];
        $filesystem = new Filesystem();
        if ($filesystem->exists($pluginPath . '/composer.json')) {
            $plugin = json_decode($filesystem->get($pluginPath . '/composer.json'), true);
        }

        // 设置插件模板根目录
        config([
            'view.paths' => [
                realpath($pluginPath . '/views')
            ],
        ]);

        // 路由模式 TODO 默认使用resource
        $routeType = array_get($plugin, 'extra.plugin.route.type', 'resource');
        switch ($routeType) {
            // 使用自定义模式
            case 'custom':
                Route::group(['prefix' => "{$group}/{$name}"], function () use ($controller, $plugin) {
                    $route = array_get($plugin, 'extra.plugin.route', []);

                    foreach ($route as $method => $options) {
                        $method = strtolower($method);
                        if (!in_array($method, ['get', 'post', 'put', 'patch', 'delete', 'options', 'any'])) {
                            continue;
                        }
                        foreach ($options as $url => $action) {
                            Route::$method($url, ['uses' => "{$controller}@{$action}"]);
                        }
                    }
                });
                break;

            // 使用controller模式
            case 'controller':
                Route::controller("{$group}/{$name}", $controller);
                break;

            // 使用resource模式
            default:
                Route::resource("{$group}/{$name}", $controller);
        }

    }
}

// 系统核心模块 (所有路由都可以使用插件进行覆盖)
Route::controller('matrix', 'MatrixController');

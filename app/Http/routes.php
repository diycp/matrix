<?php

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

// 系统模板页面
Route::group(['prefix' => 'app'], function () {

    Route::get('{html}', function ($html) {
        $view = "app.{$html}";
        return view($view);
    });

});

// 系统核心模块
Route::get('auth/user', 'AuthController@showUser');
Route::get('auth/menu', 'AuthController@showMenu');
Route::get('auth/check', 'AuthController@check');
Route::post('auth/login', 'AuthController@login');
Route::post('auth/register', 'AuthController@register');
Route::get('auth/logout', 'AuthController@logout');

// 插件模块
Route::group(['middleware' => 'auth'], function () {

    $path = app('request')->path();
    $route = explode('/', $path);

    if (count($route) >= 2) {
        $group = $route[0];
        $name = $route[1];

        $controller = '\\Laa\\' . studly_case(strtolower($group)) . '\\' . studly_case(strtolower($name)) . '\\Controller';
        if (class_exists($controller)) {
            // 反解析类
            $object = new \ReflectionClass($controller);
            $pluginPath = dirname(dirname($object->getFileName())); //插件根目录

            // 设置插件模板根目录
            config([
                'view.paths' => [
                    realpath($pluginPath . '/views')
                ],
            ]);

            Route::resource("{$group}/{$name}", $controller);
        }
    }
});
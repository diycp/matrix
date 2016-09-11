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

// 认证相关模块
Route::get('auth/user', 'AuthController@showUser');
Route::get('auth/menu', 'AuthController@showMenu');
Route::get('auth/check', 'AuthController@check');
Route::post('auth/login', 'AuthController@login');
Route::post('auth/register', 'AuthController@register');
Route::get('auth/logout', 'AuthController@logout');

// 功能模块接口
Route::group(['middleware' => 'auth'], function () {

    Route::resource('menu', 'MenuController');

});

'use strict';

angular.module('app.services', [])
// 认证模块
    .service('auth', function ($resource, $http, $injector, $q, $templateCache, $state, appServices) {
        this.data = {};
        this.init = function () {
            let that = this;
            // 获取用户信息
            $http.get('/auth/user').success(function (user) {
                that.data['user'] = user;

                // 获取用户当前菜单
                $http.get('/auth/menu').success(function (menu) {
                    that.data['menu'] = menu;
                });
            });
            console.log('service auth init');
        };
        // 检测字段是否存在
        this.check = function (field, value) {
            let that = this;
            return $q(function (resolve, reject) {
                $http.get('/auth/check?field=' + encodeURI(field) + '&value=' + encodeURI(value))
                    .success(function (data) {
                        data.exists ? resolve(data) : reject();
                    })
                    .error(function () {
                        reject();
                    });
            });
        };
        this.login = function (data) {
            let that = this;
            $http.post('/auth/login', data).then(
                function () {
                    $state.go('app.index');
                }, function () {
                    toastr.error('登录失败');
                }
            );
        };
        this.register = function (data) {
            let that = this;
            $http.post('/auth/register', data).then(
                function () {
                    $state.go('app.index');
                }, function () {
                    toastr.error('注册失败');
                }
            );
        };
        this.logout = function () {
            let that = this;
            $http.get('/auth/logout').success(function () {
                angular.forEach(appServices, function (service, name) {
                    // 清除数据
                    if (angular.isArray(service.data)) service.data = [];
                    if (angular.isObject(service.data)) service.data = {};

                    // 调用清除方法，用于清理特殊数据
                    if (typeof service.clear == 'function') {
                        return service.clear();
                    }
                });
                // $templateCache.removeAll();
                $state.go('login');
            });
        };
    })

    // 系统菜单
    .service('menu', function ($resource) {
        this.api = $resource('/menu/:id', {id: '@id'});
        this.data = [];
        this.init = function () {
            let that = this;
            this.api.getAll(function (data) {
                that.data = data;
            });
            console.log('service menu init');
        };
        this.delete = function (menu) {
            let that = this;
            menu.$delete(function () {
                that.init();
            });
            console.log('service menu delete');
        }
    });

'use strict';

angular.module('app.services', [])
// 认证模块
    .service('matrix', ['$rootScope', '$http', '$state', 'appServices', function ($rootScope, $http, $state, appServices) {
        this.data = {};
        this.init = function () {
            let that = this;
            // 获取用户信息
            $http.get('/matrix/auth').success(function (user) {
                that.data['user'] = user;

                // 获取用户当前菜单
                $http.get('/matrix/menu').success(function (menu) {
                    that.data['menu'] = menu;
                });
            });
            console.log('service matrix init');
        };
        this.logout = function () {
            let that = this;
            $http.get('/matrix/logout').success(function () {
                angular.forEach(appServices, function (service, name) {
                    // 清除数据
                    if (angular.isArray(service.data)) service.data = [];
                    if (angular.isObject(service.data)) service.data = {};

                    // 调用清除方法，用于清理特殊数据
                    if (typeof service.clear == 'function') {
                        return service.clear();
                    }
                });
                $rootScope.$emit('event:unauthorized', $state);
            });
        };
    }]);

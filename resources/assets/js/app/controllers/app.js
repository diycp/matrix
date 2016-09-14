'use strict';

angular.module('app.controllers.app', [])
// header头部部分
    .controller('HeaderCtrl', ['$scope', '$cookies', function ($scope, $cookies) {
        // 主题列表
        $scope.themeClass = [
            'skin-blue',
            'skin-black',
            'skin-purple',
            'skin-green',
            'skin-red',
            'skin-yellow',
            'skin-blue-light',
            'skin-black-light',
            'skin-purple-light',
            'skin-green-light',
            'skin-red-light',
            'skin-yellow-light'
        ];
        // 更换主题
        $scope.themeEnable = function (name) {
            $cookies.put('theme-enabled-name', name);

            angular.forEach($scope.themeClass, function (theme) {
                $scope.bodyClass[theme] = name == theme;
            });
        };
        // 初始化主题
        $scope.themeEnable($cookies.get('theme-enabled-name') || 'skin-purple-light');
    }])
    // 路由映射页面
    .controller('MapCtrl', ['$rootScope', '$scope', '$state', '$stateParams', '$location', function ($rootScope, $scope, $state, $stateParams, $location) {
        $scope.template = $location.url();
        $scope.route = $stateParams;

        // 触发视图渲染完成事件
        $scope.loaded = function () {
            $scope.$emit('$viewContentLoaded', Object.keys($state.current.views)[0]);
        };

        // 触发模版加载失败事件
        $scope.failed = function (response) {
            if (response && response.status == 401) return false; // 401已设置全局监听事件
            if (response && response.status == 500) return $state.go('app.500');
            $state.go('app.404');
        };
    }])
    // 首页
    .controller('IndexCtrl', ['$scope', function ($scope) {
        $scope.text = '# markdown';
    }])
    // 注册页面
    .controller('RegisterCtrl', ['$scope', '$q', 'appServices', function ($scope, $q, appServices) {
        $scope.data = {};

        // 验证邮箱字段
        $scope.checkEmail = function (email) {
            return $q(function (resolve, reject) {
                appServices.auth.check('email', email).then(reject, resolve);
            });
        };
        // 验证密码字段
        $scope.checkPassword = function (str) {
            return /^\w{6,30}$/.test(str);
        };
    }])
    // 登录页面
    .controller('LoginCtrl', ['$scope', '$q', 'appServices', function ($scope, $q, appServices) {
        $scope.data = {};

        // 验证邮箱字段
        $scope.checkEmail = function (email) {
            return $q(function (resolve, reject) {
                appServices.auth.check('email', email).then(resolve, reject);
            });
        };
        // 验证密码字段
        $scope.checkPassword = function (str) {
            return /^\w{6,30}$/.test(str);
        };
    }])
    // 锁屏页面
    .controller('LockCtrl', function () {

    })
;

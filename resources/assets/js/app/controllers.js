'use strict';

angular.module('app.controllers', [])
    .controller('AllCtrl', ['$rootScope', '$scope', '$state', 'appServices', function ($rootScope, $scope, $state, appServices) {
        $scope.services = appServices;
        $scope.services.init('matrix');

        // body标签class属性
        $scope.bodyClass = {
            'hold-transition': true,
            'sidebar-mini': true,
            'fixed': false
        };

        // 全屏模式
        $scope.isFullscreen = false;
        $scope.toggleFullScreen = function () {
            $scope.isFullscreen = !$scope.isFullscreen;
        };

        // 监听路由变化
        let checkLogin = false;
        $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams) {
            if (checkLogin && !angular.isObject($scope.services.matrix.data.user)) $scope.services.init('matrix');
            checkLogin = true;
        });

        // 监听视图渲染状态
        $scope.$on('$viewContentLoaded', function () {
            $.AdminLTE.layout.activate();
        });

        // 监听未登录状态
        $rootScope.$on('event:unauthorized', function (event, state) {
            if (jQuery.inArray(state.current.name, ['login', 'register']) < 0) {
                $state.go('login');
                toastr.error('请先登录');
            }
        });

    }])
    // 路由映射页面
    .controller('MapCtrl', ['$scope', '$state', '$location', function ($scope, $state, $location) {
        $scope.template = $location.url();

        // 触发视图渲染完成事件
        $scope.loaded = function () {
            $scope.$emit('$viewContentLoaded', Object.keys($state.current.views)[0]);
        };

        // 触发模版加载失败事件
        $scope.failed = function (response) {
            if (response && response.status == 401) return false;
            $state.go('app.error', {code: response.status});
        };
    }]);

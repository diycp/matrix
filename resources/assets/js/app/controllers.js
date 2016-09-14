'use strict';

import './controllers/app.js';

angular.module('app.controllers', ['app.controllers.app'])
    .controller('AllCtrl', ['$rootScope', '$scope', 'appServices', function ($rootScope, $scope, appServices) {
        $scope.services = appServices;
        $scope.services.init('auth');

        // body标签class属性
        $scope.bodyClass = {
            'hold-transition': true,
            'sidebar-mini': true,
            'fixed': false
        };

        // body标签class属性扩展
        $scope.bodyClassExtend = {
            'lockscreen': {
                name: 'lock'
            }
        };

        // 全屏模式
        $scope.isFullscreen = false;
        $scope.toggleFullScreen = function () {
            $scope.isFullscreen = !$scope.isFullscreen;
        };

        // 监听路由变化
        $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams) {
            if (!angular.isObject($scope.services.auth.data.user)) $scope.services.init('auth');

            angular.forEach($scope.bodyClassExtend, function (extend, value) {
                $scope.bodyClass[value] = (toState.name == extend.name || toState.url == extend.url);
            });
        });

        // 监听视图渲染状态
        $scope.$on('$viewContentLoaded', function () {
            $.AdminLTE.layout.activate();
        });

    }]);

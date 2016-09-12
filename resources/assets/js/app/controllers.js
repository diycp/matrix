'use strict';

import './controllers/app.js';

angular.module('app.controllers', ['app.controllers.app'])
    .controller('AllCtrl', ['$rootScope', '$scope', 'appServices', 'DTDefaultOptions', function ($rootScope, $scope, appServices, DTDefaultOptions) {
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

        // 设置datatable中文显示
        DTDefaultOptions.setLanguage({
            "sEmptyTable": "No data available in table",
            "sInfo": "显示 _START_ 到 _END_ 共 _TOTAL_ 条",
            "sInfoEmpty": "显示 0 到 0 共 0 条",
            "sInfoFiltered": "（总数 _MAX_ 条中搜索）",
            "sInfoPostFix": "",
            "sInfoThousands": ",",
            "sLengthMenu": "每页 _MENU_ 条",
            "sLoadingRecords": "Loading...",
            "sProcessing": "Processing...",
            "sSearch": "搜索：",
            "sZeroRecords": "没有获取到数据",
            "oPaginate": {
                "sFirst": "首页",
                "sLast": "尾页",
                "sNext": "下一页",
                "sPrevious": "上一页"
            },
            "oAria": {
                "sSortAscending": ": activate to sort column ascending",
                "sSortDescending": ": activate to sort column descending"
            }
        });
    }]);

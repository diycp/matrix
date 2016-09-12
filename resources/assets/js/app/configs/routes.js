'use strict';

angular.module('app.configs.routes', [])
    .config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.when('', '/');
        $urlRouterProvider.otherwise('/404');

        $stateProvider
            .state("app", {
                abstract: true,
                views: {
                    'layout': {
                        template: `
<div class="wrapper">
    <div ui-view="header"></div>
    <div ui-view="menu"></div>
    <div class="content-wrapper" ui-view="main"></div>
    <div ui-view="footer"></div>
</div>
`,
                    },
                    'header@app': {
                        templateUrl: '/app/header',
                        controller: 'HeaderCtrl'
                    },
                    'menu@app': {
                        templateUrl: '/app/menu'
                    },
                    'footer@app': {
                        templateUrl: '/app/footer'
                    }
                }
            })
            .state('login', {
                url: '/login',
                views: {
                    'layout': {
                        templateUrl: '/app/login',
                        controller: 'LoginCtrl'
                    }
                }
            })
            .state('register', {
                url: '/register',
                views: {
                    'layout': {
                        templateUrl: '/app/register',
                        controller: 'RegisterCtrl'
                    }
                }
            })
            .state('lock', {
                url: '/lock',
                views: {
                    'layout': {
                        templateUrl: '/app/lock',
                        controller: 'LockCtrl'
                    }
                }
            })
            .state('app.index', {
                url: '/',
                views: {
                    'main@app': {
                        templateUrl: '/app/index',
                        controller: 'IndexCtrl'
                    }
                }
            })
            .state('app.404', {
                url: '/404',
                views: {
                    'main@app': {
                        templateUrl: '/app/404'
                    }
                }
            })
            .state('app.500', {
                url: '/500',
                views: {
                    'main@app': {
                        templateUrl: '/app/500'
                    }
                }
            })
            // TODO 这条规则必须放在最下面,否则会导致其他路由不生效
            .state('app.map', {
                url: '/*map',
                views: {
                    'main@app': {
                        templateUrl: '/app/map',
                        controller: 'MapCtrl'
                    }
                }
            });
    }]);
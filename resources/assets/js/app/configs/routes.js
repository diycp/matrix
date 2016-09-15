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
                        templateUrl: '/matrix/header'
                    },
                    'menu@app': {
                        templateUrl: '/matrix/aside'
                    },
                    'footer@app': {
                        templateUrl: '/matrix/footer'
                    }
                }
            })
            .state('login', {
                url: '/login',
                views: {
                    'layout': {
                        templateUrl: '/matrix/login'
                    }
                }
            })
            .state('register', {
                url: '/register',
                views: {
                    'layout': {
                        templateUrl: '/matrix/register'
                    }
                }
            })
            .state('lock', {
                url: '/lock',
                views: {
                    'layout': {
                        templateUrl: '/matrix/lock'
                    }
                }
            })
            .state('app.index', {
                url: '/',
                views: {
                    'main@app': {
                        templateUrl: '/matrix/index'
                    }
                }
            })
            .state('app.404', {
                url: '/404',
                views: {
                    'main@app': {
                        templateUrl: '/matrix/empty'
                    }
                }
            })
            .state('app.500', {
                url: '/500',
                views: {
                    'main@app': {
                        templateUrl: '/matrix/error'
                    }
                }
            })
            // TODO 这条规则必须放在最下面,否则会导致其他路由不生效
            .state('app.map', {
                url: '/*map',
                views: {
                    'main@app': {
                        templateUrl: '/matrix/map'
                    }
                }
            });
    }]);
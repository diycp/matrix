'use strict';

window.PLUGIN = angular.module('app.plugins', [])
    .config(['$stateProvider', '$urlRouterProvider', function ($stateProvider) {
        $stateProvider
            .state("app", {
                abstract: true,
                views: {
                    'layout': {
                        template: `
<div class="wrapper">
    <div ui-view="header"></div>
    <div ui-view="aside"></div>
    <div class="content-wrapper" ui-view="main"></div>
    <div ui-view="footer"></div>
</div>
`,
                    },
                    'header@app': {
                        templateUrl: '/matrix/header'
                    },
                    'aside@app': {
                        templateUrl: '/matrix/aside'
                    },
                    'footer@app': {
                        templateUrl: '/matrix/footer'
                    }
                }
            });
    }]);
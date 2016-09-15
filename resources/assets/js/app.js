'use strict';

import './app/configs.js';
import './app/services.js';
import './app/factorys.js';
import './app/controllers.js';
import './app/directives.js';
import './app/filters.js';

angular.module('app', [
    'app.bower',
    'app.modules'
]);

angular.module('app.bower', [
    'ngResource',
    'ngAnimate',
    'ngCookies',
    'ngSanitize',
    'ngAria',
    'ui.router',
    'ui.validate',
    'FBAngular',
    'hc.marked',
    'ngMaterial',
    'md.data.table',
    'monospaced.qrcode'
]);

angular.module('app.modules', [
    'app.configs',
    'app.factorys',
    'app.services',
    'app.controllers',
    'app.directives',
    'app.filters',
    'app.plugins'
])
    .config(['$stateProvider', function ($stateProvider) {
        // TODO 当前路由规则必须放到最后执行,否则容易出现冲突
        $stateProvider
            .state('app.map', {
                url: '/*map',
                views: {
                    'main@app': {
                        template: '<app-include ng-controller="MapCtrl" src="template" onload="loaded" onfail="failed">loading...</app-include>',
                        controller: 'MapCtrl'
                    }
                }
            });
    }]);

$(document).ready(function () {
    angular.bootstrap(document, ['app']);
});
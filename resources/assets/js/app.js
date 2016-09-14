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
]);

$(document).ready(function () {
    angular.bootstrap(document, ['app']);
});
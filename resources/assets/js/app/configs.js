'use strict';

angular.module('app.configs', [])
    .config(['$httpProvider', function ($httpProvider) {
        $httpProvider.interceptors.push('appHttpInterceptor');
    }])
    .config(['$resourceProvider', function ($resourceProvider) {
        $resourceProvider.defaults.actions = {
            create: {method: 'POST'},
            get: {method: 'GET', params: {dataType: 'json'}},
            getAll: {method: 'GET', isArray: true, params: {dataType: 'json'}},
            update: {method: 'PUT'},
            delete: {method: 'DELETE'}
        };
    }])
    .config(['markedProvider', function (markedProvider) {
        markedProvider.setOptions({
            gfm: true,
            tables: true
        });
    }]);

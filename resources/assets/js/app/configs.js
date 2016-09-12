'use strict';

import './configs/routes.js';

angular.module('app.configs', [
    'app.configs.routes'
])
    .config(function ($httpProvider) {
        $httpProvider.interceptors.push('appHttpInterceptor');
    })
    .config(function ($resourceProvider) {
        $resourceProvider.defaults.actions = {
            create: {method: 'POST'},
            get: {method: 'GET', params: {dataType: 'json'}},
            getAll: {method: 'GET', isArray: true, params: {dataType: 'json'}},
            update: {method: 'PUT'},
            delete: {method: 'DELETE'}
        };
    })
    .config(function (markedProvider) {
        markedProvider.setOptions({
            gfm: true,
            tables: true
        });
    });

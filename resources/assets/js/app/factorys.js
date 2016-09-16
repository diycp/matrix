'use strict';

angular.module('app.factorys', [])
// $http拦截器，用于监听$http请求
    .factory('appHttpInterceptor', ['$rootScope', '$q', '$injector', function ($rootScope, $q, $injector) {
        return {
            'responseError': function (response) {
                if (response.status == 401) {
                    let $state = $injector.get('$state');
                    $rootScope.$emit('event:unauthorized', $state);
                }
                return $q.reject(response);
            },
            'response': function (response) {
                return response;
            },
            'request': function (config) {
                return config;
            },
            'requestError': function (config) {
                return $q.reject(config);
            }
        };
    }])

    // service加载器
    .factory('appServices', ['$injector', function ($injector) {
        return {
            init: function (name, params) {
                let service = $injector.get(name);

                this[name] = service;

                if (typeof service.init == 'function') {
                    return service.init(params);
                }
                return null;
            }
        };
    }])

    // 数据转换
    .factory('appConvert', function () {
        return {
            dateUrl2Blob: function (dataUrl) {
                // data:image/jpeg;base64,xxxxxx
                var datas = dataUrl.split(',', 2);
                var mime = datas[0].split(';')[0].split(':')[1];

                var code = atob(datas[1]);
                var aBuffer = new ArrayBuffer(code.length);
                var uBuffer = new Uint8Array(aBuffer);
                for (var i = 0; i < code.length; i++) {
                    uBuffer[i] = code.charCodeAt(i) & 0xff;
                }
                var blob = new Blob([uBuffer], {type: mime});
                blob.name = blob.fileName = 'base64.' + mime.split('/')[1];

                return blob;
            }
        };
    });

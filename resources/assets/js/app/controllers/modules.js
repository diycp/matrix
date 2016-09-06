'use strict';

angular.module('app.controllers.modules', [])
// 菜单管理
    .controller('MenuIndexCtrl', function ($scope, $q, appServices, DTOptionsBuilder) {
        appServices.init('menu');

        $scope.options = DTOptionsBuilder.newOptions()
            .withPaginationType('full_numbers')
            .withOption('rowCallback', function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td', nRow).one('click', function() {
                    $scope.$apply(function() {
                        console.log(nRow, aData, iDisplayIndex, iDisplayIndexFull);
                    });
                });
                return nRow;
            });
    });

'use strict';
angular
    .module('app.core')
    .controller('DetalleController', function($scope, PageValues, $timeout, _detalle) {
        //Set page title and description
        PageValues.title = "HOME";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;
        vm.pagina = angular.isDefined(_detalle) ? _detalle : {};

        vm.base = 'http://ja.dev';
        vm.url = vm.base + '/' + vm.pagina.categoria + '/' + vm.pagina.slug;

        $scope.dynamicMeta = "Initial value";
        $timeout(function(){
            $scope.dynamicMeta = "Value updated by timeout after 5 seconds";
        }, 1000);

    });

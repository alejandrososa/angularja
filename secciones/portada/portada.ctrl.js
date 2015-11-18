'use strict';
angular
    .module('app.core')
    .controller('PortadaController', function($scope, PageValues, _datos) {
        //Set page title and description
        PageValues.title = "HOME";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;
        vm.pagina = angular.isDefined(_datos) ? _datos : {};
        vm.configuracion = angular.isDefined(vm.pagina.configuracion) ? vm.pagina.configuracion : {};

        var b1cantidad = angular.isDefined(vm.configuracion.bloque1.numarticulos) ? vm.configuracion.bloque1.numarticulos : 4;

        vm.bloque1 = {
            categoria: 'articulosrecientes',
            estilo: 'recientes',
            cantidad: b1cantidad,
        };
        vm.bloque2 = {
            categoria: 'articulos',
            estilo: 'defecto'
        };

    });




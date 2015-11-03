'use strict';
angular
    .module('app.core')
    .controller('PortadaController', function($scope, PageValues) {
        //Set page title and description
        PageValues.title = "HOME";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;

        vm.bloque1 = {
            categoria: 'articulos',
            estilo: 'defecto',
            cantidad: 2,
        };
        vm.bloque2 = {
            categoria: 'articulos',
            estilo: 'defecto'
        };

    });

'use strict';
angular
    .module('app.core')
    .controller('PortadaController', function($scope, PageValues, Categorias, _datos) {
        //Set page title and description
        PageValues.title = "HOME";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;
        vm.pagina = angular.isDefined(_datos) ? _datos : {};
        vm.configuracion = angular.isDefined(vm.pagina.configuracion) ? vm.pagina.configuracion : {};

        //SEO
       // vm.pagina.metapalabras = '';



        //BLOQUES
        var b1cantidad = angular.isDefined(vm.configuracion.principal) ? vm.configuracion.principal.bloque1.numarticulos : 4;
        var b1visible = angular.isDefined(vm.configuracion.principal) ? vm.configuracion.principal.bloque1.visible : true;

        var b2cantidad = angular.isDefined(vm.configuracion.principal) ? vm.configuracion.principal.bloque2.numarticulos : 4;
        var b2categoria = angular.isDefined(vm.configuracion.principal) ? vm.configuracion.principal.bloque2.categoria : 'articulos';
        var b2visible = angular.isDefined(vm.configuracion.principal) ? vm.configuracion.principal.bloque2.visible : true;


        vm.principal = {};
        vm.colcentro = {};
        vm.colderecha = {};


        vm.principal.bloque1 = {
            categoria: 'articulosrecientes',
            estilo: 'recientes',
            cantidad: b1cantidad,
            visible: b2visible
        };
        vm.principal.bloque2 = {
            categoria: b2categoria,
            estilo: 'defecto',
            cantidad: b2cantidad,
            visible: b1visible
        };

        vm.colcentro.bloque1 = {
            categoria: b2categoria,
            estilo: 'listadoarticulos',
            cantidad: b2cantidad,
            visible: b1visible
        };
        vm.colcentro.bloque2 = {
            categoria: b2categoria,
            estilo: 'listadoarticulosconfotos',
            cantidad: b2cantidad,
            visible: b1visible
        }


    });




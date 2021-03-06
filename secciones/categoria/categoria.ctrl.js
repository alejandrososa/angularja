'use strict';
angular
    .module('app.core')
    .controller('CategoriaController', function($scope, PageValues, _categoria) {
        //Set page title and description
        PageValues.title = "HOME";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;



        vm.proveedor = {
            id: _categoria.id,
            titulo: _categoria.titulo,
            datos: _categoria.lista,
        };

        vm.listado = {
            categoria: 'noticias',
            estilo: 'categoria'
        };

    });

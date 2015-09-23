/**
 * Created by Alejandro on 18/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('AdminController', function($scope, $rootScope, PageValues, Usuarios) {
        //Set page title and description
        PageValues.title = "Admin";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;

        vm.vista = $rootScope.vista;

        vm.usuarios = {};
        vm.tblsortType     = 'name'; // set the default sort type
        vm.tblsortReverse  = false;  // set the default sort order
        vm.tblsearchFish   = '';     //

        Usuarios.getUsuarios().then(function(respuesta){
            vm.usuarios = respuesta;
        });

    });
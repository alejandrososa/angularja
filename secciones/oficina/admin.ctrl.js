/**
 * Created by Alejandro on 18/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('AdminController', function($scope, $rootScope, PageValues, Usuarios, $routeParams, persona) {
        //Set page title and description
        PageValues.title = "Admin";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;

        vm.vista = $rootScope.vista;

        //USUARIO
        vm.persona = {};


        vm.persona =  persona; //usuarios.one($routeParams.id);

        console.log(persona.correo);


        //USUARIOS

        vm.usuarios = {};
        vm.tblsortType     = 'name'; // set the default sort type
        vm.tblsortReverse  = false;  // set the default sort order
        vm.tblsearchFish   = '';     //

        /*usuarios.getUsuarios().then(function(respuesta){
            vm.usuarios = respuesta;
        });
        */
    });
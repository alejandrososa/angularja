/**
 * Created by Alejandro on 20/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('UsuariosController', function($scope, $rootScope, PageValues, $cookieStore,
                                               $q, $location, $auth, $log, toastr, $window,
                                               $routeParams, Usuarios, _datos) {

        var vm = this;

        vm.vista = $auth.isAuthenticated();
        vm.menu = $rootScope.menu;


        if (!$auth.isAuthenticated()) {
            $location.path('/login');
        }


        vm.usuario = {};
        vm.usuarios = [];
        vm.tblsortType     = 'nombre'; // set the default sort type
        vm.tblsortReverse  = false;  // set the default sort order
        vm.tblsearchFish   = '';     //

        vm.idUsuario = ($routeParams.id) ? parseInt($routeParams.id) : 0;
        vm.botonTexto = (vm.idUsuario > 0) ? 'Actualizar' : 'Agregar';
        vm.tipo = (vm.idUsuario > 0) ? true : false;

        //usuarios
        vm.usuarios = _datos;

        //usuario
        vm.usuario = {
            id          : _datos.uid,
            nombre      : _datos.nombre,
            correo      : _datos.correo,
            tel         : _datos.telefono,
            direccion   : _datos.direccion,
            ciudad      : _datos.ciudad
        };

        //acciones
        vm.procesar = function(isValid, tipo){
            if(!isValid){
                console.log('no es valido');
                return;
            }

            if(!tipo){
                vm.crear();
            }else{
                vm.editar()
            }
        }

        vm.crear = function (){
            console.log('crear:' + vm.usuario);
        }

        vm.editar = function (){
            console.log('editar:' + vm.usuario);
        }



        vm.hola = vm.usuarios;




        /**
         * End sidebar
         */

        $scope.alerts = [{
            type: 'success',
            msg: 'Thanks for visiting! Feel free to create pull requests to improve the dashboard!'
        }, {
            type: 'danger',
            msg: 'Found a bug? Create an issue with as many details as you can.'
        }];

        $scope.addAlert = function() {
            $scope.alerts.push({
                msg: 'Another alert!'
            });
        };

        $scope.closeAlert = function(index) {
            $scope.alerts.splice(index, 1);
        };

    });
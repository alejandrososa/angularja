/**
 * Created by Alejandro on 20/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('MasterController', function($scope, $rootScope, PageValues, $cookieStore,
                                             $q, $location, $auth, $log, toastr, $window, Usuarios) {

        var vm = this;

        vm.vista = $auth.isAuthenticated();
        vm.menu = $rootScope.menu;


        if (!$auth.isAuthenticated()) {
            $$location.path('/login');
        }


        vm.usuarios = [];
        vm.tblsortType     = 'name'; // set the default sort type
        vm.tblsortReverse  = false;  // set the default sort order
        vm.tblsearchFish   = '';     //

        Usuarios.getUsuarios().then(function(respuesta){
            vm.usuarios = JSON.parse(respuesta.resultado);
        });



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
/**
 * Created by Alejandro on 18/09/2015.
 */
'use strict';
angular
    .module('app.core')
    .controller('LoginController', function($q, $rootScope, $location, $auth, $log, toastr, $window) {
        var vm = this;

        vm.logout = function() {
            var deferred = $q.defer();

            //if (!$auth.isAuthenticated()) { return; }

            $log.info('La sesión se ha cerrado');
            $auth.logout()
                .then(function() {
                    toastr.info('La sesion se ha cerrado');
                    $window.location.href = '/';
                    //$location.path('/');
                });
        };

    });
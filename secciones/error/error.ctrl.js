/**
 * Created by Alejandro on 18/09/2015.
 */
'use strict';
angular
    .module('app.core')
    .controller('ErrorController', function($scope, PageValues, $location, $auth, $log, toastr) {
        //Set page title and description
        PageValues.title = "HOME";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;


        vm.login = function() {
            $auth.login(vm.persona)
                .then(function() {
                    toastr.success('You have successfully signed in');
                    $location.path('/');
                })
                .catch(function(response) {
                    //console.clear();
                    $log.reset;
                    $log.warn('No esta autorizado');
                    toastr.error(response.data.message, response.status); //response.data.message
                    $location.path('/login');

                });
        };
        vm.authenticate = function(provider) {
            $auth.authenticate(provider)
                .then(function() {
                    toastr.success('You have successfully signed in with ' + provider);
                    $location.path('/');
                })
                .catch(function(response) {
                    toastr.error(response.message);
                });
        };

    });
/**
 * Created by Alejandro on 18/09/2015.
 */
'use strict';
angular
    .module('app.core')
    .controller('LoginController', function($scope, $rootScope, PageValues, $location, $auth, $log, toastr, $window) {
        //Set page title and description
        PageValues.title = "HOME";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;

        vm.vista = $rootScope.vista;



        vm.authenticate = function(provider) {
            $auth.authenticate(provider)
                .then(function() {
                    toastr.success('You have successfully signed in with ' + provider);
                    $location.path('/admin');
                    //$window.location.href = '/admin/';
                })
                .catch(function(response) {
                    toastr.error(response.message);
                });
        };





    });
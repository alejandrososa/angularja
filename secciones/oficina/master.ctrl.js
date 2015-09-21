/**
 * Created by Alejandro on 20/09/2015.
 */
'use strict';
angular
    .module('app.core')
    .controller('MasterController', function($scope, $rootScope, PageValues, $cookieStore,
                                             $q, $location, $auth, $log, toastr, $window) {

        var vm = this;

        vm.vista = $auth.isAuthenticated();


        if (!$auth.isAuthenticated()) {
            $$location.path('/login');
        }


        $scope.logout = function() {
            var deferred = $q.defer();

            $log.info('La sesión se ha cerrado');
            $auth.logout()
                .then(function() {
                    //$window.location.href = '/login';
                    $location.path('/');
                });
        };

        /**
         * Sidebar Toggle & Cookie Control
         */
        var mobileView = 992;

        $scope.getWidth = function() {
            return window.innerWidth;
        };

        $scope.$watch($scope.getWidth, function(newValue, oldValue) {
            if (newValue >= mobileView) {
                if (angular.isDefined($cookieStore.get('toggle'))) {
                    $scope.toggle = ! $cookieStore.get('toggle') ? false : true;
                } else {
                    $scope.toggle = true;
                }
            } else {
                $scope.toggle = false;
            }

        });

        $scope.toggleSidebar = function() {
            $scope.toggle = !$scope.toggle;
            $cookieStore.put('toggle', $scope.toggle);
        };

        window.onresize = function() {
            $scope.$apply();
        };



    });
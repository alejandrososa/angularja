/**
 * Created by Alejandro on 18/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('AdminController', function($scope, $rootScope, PageValues, Usuarios, $routeParams,
                                            triSettings, triLayout) {
        //Set page title and description
        PageValues.title = "Admin";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;

        vm.vista = $rootScope.vista;


        // we need to use the scope here because otherwise the expression in md-is-locked-open doesnt work
        $scope.layout = triLayout.layout; //eslint-disable-line
        //var vm = this;

        vm.activateHover = activateHover;
        vm.removeHover  = removeHover;

        ////////////////

        function activateHover() {
            if(triLayout.layout.sideMenuSize === 'icon') {
                //$element.find('.admin-sidebar-left').addClass('hover');
                angular.element.find('.admin-sidebar-left').addClass('hover');
            }
        }

        function removeHover () {
            if(triLayout.layout.sideMenuSize === 'icon') {
                //$element.find('.admin-sidebar-left').removeClass('hover');
            }
        }


        //***
        // menu
        // **///

        vm.layout = triLayout.layout;
        vm.sidebarInfo = {
            appName: triSettings.name,
            appLogo: triSettings.logo
        };
        vm.toggleIconMenu = toggleIconMenu;

        ////////////
        function toggleIconMenu() {
            var menu = vm.layout.sideMenuSize === 'icon' ? 'full' : 'icon';
            triLayout.setOption('sideMenuSize', menu);
        }


    });
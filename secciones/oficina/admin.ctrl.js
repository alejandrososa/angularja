/**
 * Created by Alejandro on 18/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('AdminController', function($scope, $rootScope, PageValues, Usuarios, $routeParams,
                                            triSettings, triLayout)  {
        //Set page title and description
        PageValues.title = "Admin";
        PageValues.description = "Learn AngularJS using best practice real world examples.";
        //Setup view model object
        var vm = this;

        vm.vista = $rootScope.vista;


        // we need to use the scope here because otherwise the expression in md-is-locked-open doesnt work
        $scope.layout = triLayout.layout; //eslint-disable-line
        vm.layout = triLayout.layout; //eslint-disable-line
        //var vm = this;


        //***
        // menu
        // **///


        vm.sidebarInfo = {
            appName: triSettings.name,
            appLogo: triSettings.logo
        };
        vm.toggleIconMenu = toggleIconMenu;

        console.log(vm.sidebarInfo.appLogo);

        ////////////
        function toggleIconMenu() {
            var menu = vm.layout.sideMenuSize === 'icon' ? 'full' : 'icon';
            triLayout.setOption('sideMenuSize', menu);
            console.log('clic icon menu');
        }


    });
/**
 * 
 */
angular
    .module('app.coreoficina')
    .directive('cmsSidebar', menu);
function menu() {  //ShowService
    var directive = {
        controller: controller,
        controllerAs: 'vm',
        bindToController: true,
        templateUrl: 'secciones/oficina/html/directivas/sidebar/sidebar.tpl.html',
        restrict: 'E',
        scope: {
            menu: '=?menu'
        }
    };
    return directive;
    function controller($scope, $rootScope, triSettings, triLayout){

        var vm = this;

        // we need to use the scope here because otherwise the expression in md-is-locked-open doesnt work
        $scope.layout = triLayout.layout; //eslint-disable-line
        //var vm = this;

        vm.activateHover = activateHover;
        vm.removeHover  = removeHover;

        ////////////////

        function activateHover() {
            if(triLayout.layout.sideMenuSize === 'icon') {
                angular.element('.admin-sidebar-left').addClass('hover');
                //angular.element.find('.admin-sidebar-left').addClass('hover');
            }
        }

        function removeHover () {
            if(triLayout.layout.sideMenuSize === 'icon') {
                angular.element('.admin-sidebar-left').removeClass('hover');
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

        console.log(vm.sidebarInfo.appLogo);

        ////////////
        function toggleIconMenu() {
            var menu = vm.layout.sideMenuSize === 'icon' ? 'full' : 'icon';
            triLayout.setOption('sideMenuSize', menu);
            console.log('clic icon menu');
        }

    }
}
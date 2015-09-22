/**
 * 
 */
angular
    .module('app.coreoficina')
    .directive('cmsMenu', menu);
function menu() {  //ShowService
    var directive = {
        controller: controller,
        controllerAs: 'vm',
        bindToController: true,
        templateUrl: 'secciones/oficina/html/directivas/menu/menu.tpl.html',
        restrict: 'E',
        scope: {
            menu: '='
        }
    };
    return directive;
    function controller($scope, $rootScope, PageValues, $cookieStore,
                        $q, $location, $auth, $log, toastr, $window){

        var vm = this;

        vm.logout = function() {
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

        vm.getWidth = function() {
            return window.innerWidth;
        };

        $scope.$watch(vm.getWidth, function(newValue, oldValue) {
            if (newValue >= mobileView) {
                if (angular.isDefined($cookieStore.get('menu'))) {
                    vm.menu = ! $cookieStore.get('menu') ? false : true;
                    $rootScope.menu = vm.menu;
                } else {
                    vm.menu = true;
                    $rootScope.menu = vm.menu;
                }
            } else {
                vm.menu = false;
                $rootScope.menu = vm.menu;
            }

        });

        vm.toggleSidebar = function() {
            vm.menu = !vm.menu;
            $rootScope.menu = vm.menu;
            $cookieStore.put('toggle', vm.menu);
        };

        window.onresize = function() {
            //$scope.$apply();
            $rootScope.$apply();
        };
    }
}
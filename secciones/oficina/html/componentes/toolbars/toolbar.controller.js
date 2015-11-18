    'use strict';

    angular
        .module('app.coreoficina')
        .directive('cmsToolbar', menu);
    function menu() {  //ShowService
        var directive = {
            controller: controller,
            controllerAs: 'vm',
            bindToController: true,
            templateUrl: 'secciones/oficina/html/componentes/toolbars/toolbar.tmpl.html',
            restrict: 'E',
            scope: {
                menu: '=?menu',
                tipo: '@?tipo',
                datos: '=?datos',
                proveedor: '=?proveedor'
            }
        };
        return directive;

    /* @ngInject $translate, */
    function controller ($scope, $mdMedia, $element, $filter, $mdUtil, $mdSidenav,
                         $mdToast, $timeout, triBreadcrumbsService, triSettings, triLayout) {
        var vm = this;
        vm.breadcrumbs = triBreadcrumbsService.breadcrumbs;
        vm.emailNew = false;
        vm.languages = triSettings.languages;
        vm.openSideNav = openSideNav;
        vm.hideMenuButton = hideMenuButton;
        vm.switchLanguage = switchLanguage;
        vm.toggleNotificationsTab = toggleNotificationsTab;
        vm.guardar = guardar;
        vm.visible = false;
        vm.tblServicio = angular.isDefined(vm.proveedor) ? vm.proveedor.servicio : null;
        var Servicio = vm.tblServicio;







        if(angular.isDefined(vm.tipo)) {
            switch (vm.tipo) {
                case 'portada':
                    vm.visible = true;
                    break;
                case 'paginas':
                    vm.visible = true;
                    break;
                case 'categorias':
                    vm.visible = true;
                    break;
                case 'menu':
                    vm.visible = true;
                    break;
                default:
                    vm.visible = false;
            }
        }



        // initToolbar();

        ////////////////

        function guardar(){
            if(angular.isDefined(vm.tipo)) {
                switch (vm.tipo) {
                    case 'portada':
                        Servicio.guardarPortada(vm.datos);
                        break;
                    case 'paginas':
                        Servicio.crear(vm.datos);
                        break;
                    case 'categorias':
                        break;
                    case 'menu':
                        break;
                    default:
                        Servicio.crear(vm.datos);
                }
            }
        }

        function openSideNav(navID) {
            $mdUtil.debounce(function(){
                $mdSidenav(navID).toggle();
            }, 300)();
        }

        function switchLanguage(languageCode) {
            /*$translate.use(languageCode)
            .then(function() {
                $mdToast.show(
                    $mdToast.simple()
                    .content($filter('translate')('MESSAGES.LANGUAGE_CHANGED'))
                    .position('bottom right')
                    .hideDelay(500)
                );
            });
            */
        }

        function hideMenuButton() {
            return triLayout.layout.sideMenuSize !== 'hidden' && $mdMedia('gt-md');
        }

        function toggleNotificationsTab(tab) {
            $scope.$parent.$broadcast('triSwitchNotificationTab', tab);
            vm.openSideNav('notifications');
        }

        $scope.$on('newMailNotification', function(){
            vm.emailNew = true;
        });
    }
}
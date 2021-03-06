
    'use strict';

    angular
        .module('app.coreoficina')
        .directive('triMenuItem', triMenuItemDirective);

    /* @ngInject */
    function triMenuItemDirective() {
        // Usage:
        //
        // Creates:
        //
        var directive = {
            restrict: 'E',
            require: '^triMenu',
            scope: {
                item: '='
            },
            replace: true,
            template: '<div ng-include="::triMenuItem.item.template"></div>',
            controller: triMenuItemController,
            controllerAs: 'triMenuItem',
            bindToController: true
        };
        return directive;
    }

    /* @ngInject */
    function triMenuItemController($scope, $mdSidenav, $route, $location, $filter, triBreadcrumbsService) {
        var triMenuItem = this;
        // load a template for this directive based on the type ( link | dropdown )
       // console.log(triMenuItem.item.type);
        triMenuItem.item.template = 'secciones/oficina/html/componentes/menu/menu-item-' + triMenuItem.item.type + '.tmpl.html';

        switch(triMenuItem.item.type) {
            case 'dropdown':
                // if we have kids reorder them by priority
                triMenuItem.item.children = $filter('orderBy')(triMenuItem.item.children, 'priority');
                triMenuItem.toggleDropdownMenu = toggleDropdownMenu;
                // add a check for open event
                $scope.$on('toggleDropdownMenu', function(event, item, open) {
                    // if this is the item we are looking for
                    if(triMenuItem.item === item) {
                        triMenuItem.item.open = open;
                    }
                    else {
                        triMenuItem.item.open = false;
                    }
                });
                // this event is emitted up the tree to open parent menus
                $scope.$on('openParents', function() {
                    // openParents event so open the parent item
                    triMenuItem.item.open = true;
                    // also add this to the breadcrumbs
                    triBreadcrumbsService.addCrumb(triMenuItem.item);
                });
                break;
            case 'link':
                triMenuItem.openLink = openLink;

                // on init check if this is current menu
                checkItemActive($route.current.name, $route.params);

                $scope.$on('$routeChangeSuccess', function(event, toState, toParams) {
                    checkItemActive(toState.name, toParams); //checkItemActive(current.name, pre);
                });
                break;
        }

        function checkItemActive() {

            $scope.esActual = function (param1, param2) {
                if (param1 === param2) {
                    return true;
                }
                return false;
            };

            var rutamenu = '/'+triMenuItem.item.route;
            var rutaactual = $location.path();

            triMenuItem.item.active = $scope.esActual(rutamenu, rutaactual)

            // first check if the state is the same
            //triMenuItem.item.active = $route.includes(triMenuItem.item.route, triMenuItem.item.params);
            // if we are now the active item reset the breadcrumbs and open all parent dropdown items
            if(triMenuItem.item.active) {
                triBreadcrumbsService.reset();
                triBreadcrumbsService.addCrumb(triMenuItem.item);
                $scope.$emit('openParents');
            }
        }

        function toggleDropdownMenu() {
            $scope.$parent.$parent.$broadcast('toggleDropdownMenu', triMenuItem.item, !triMenuItem.item.open);
        }

        function openLink() {
            var params = angular.isUndefined(triMenuItem.item.params) ? {} : triMenuItem.item.params;
            $location.path(triMenuItem.item.route); //, params);
            triMenuItem.item.active = true;
            $mdSidenav('left').close();
        }
    }
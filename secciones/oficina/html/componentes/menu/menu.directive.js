    'use strict';

    angular
        .module('app.coreoficina')
        .directive('triMenu', triMenuDirective);

    /* @ngInject */
        function triMenuDirective($location, $mdTheming, triTheming, triSkins) {
        // Usage:
        //
        // Creates:
        //
        var directive = {
            restrict: 'E',
            template: '<md-content><tri-menu-item ng-repeat="item in triMenuController.menu | orderBy:\'priority\'" item="::item"></tri-menu-item></md-content>',
            scope: {},
            controller: triMenuController,
            controllerAs: 'triMenuController',
            link: link
        };
        return directive;

        function link($scope, $element) {

            //var themes = triSkins.elements['sidebar'];

            //console.log(themes);



            $mdTheming($element);
            var $mdTheme = $element.controller('mdTheme'); //eslint-disable-line

            var menuColor = triTheming.getThemeHue('cyan', 'primary', 'default'); //$mdTheme.$mdTheme
            var menuColorRGBA = triTheming.rgba(menuColor.value);
            $element.css({ 'background-color': menuColorRGBA });
            $element.children('md-content').css({ 'background-color': menuColorRGBA });
        }
    }

    /* @ngInject */
    function triMenuController(triMenu, triSettings, triLayout) {
            var vm = this;
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

            //vm.skinSidebar = triSkins.elements['sidebar'];

        /*
        triMenu.addMenu({
            name: 'MENU.MENU.DYNAMIC-MENU',
            icon: 'zmdi zmdi-flower-alt',
            type: 'link',
            priority: 0.0,
            route: 'triangular.admin-default.menu-dynamic-dummy-page'
        });
        */

        var triMenuController = this;
        // get the menu and order it
        triMenuController.menu = triMenu.menu;

        console.log(triMenu.menu)
    }


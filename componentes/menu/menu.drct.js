/**
 * 
 */
angular
    .module('app.core')
    .directive('portalMenu', portalMenu);
function portalMenu() {  //ShowService
    var tipo = '';
    var directive = {
        controller: controller,
        controllerAs: 'vm',
        bindToController: true,
        templateUrl: plantilla,
        restrict: 'E',
        scope: {
            tipo: '@tipo'
        }
    };
    return directive;

    function plantilla(elem, attr){
        return 'componentes/menu/menu-'+attr.tipo+'.tpl.html';
    }

    function controller(Menu) {
        var vm = this;
        vm.datosmenu = [];

        Menu.seleccionar(vm.tipo).then(function(datos){
            vm.datosmenu = datos.resultado;
        });
    }
}
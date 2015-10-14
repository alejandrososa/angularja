/**
 * 
 */
angular
    .module('app.core')
    .directive('portalMenu', menu);
function menu() {  //ShowService
    var directive = {
        controller: controller,
        controllerAs: 'vm',
        bindToController: true,
        templateUrl: 'componentes/menu/menu.tpl.html',
        restrict: 'E',
        scope: {
            menu: '='
        }
    };
    return directive;
    function controller($scope, Menu) {

        var vm = this;

        vm.menuPrincipal = [];

        Menu.principal().then(function(datos){
            vm.menuPrincipal = datos.resultado;
            console.log(vm.menuPrincipal);
        });
    }
}
/**
 * 
 */
angular
    .module('app.core')
    .directive('portalMenutop', menu);
function menu() {  //ShowService
    var directive = {
        controller: controller,
        controllerAs: 'vm',
        bindToController: true, //required in 1.3+ with controllerAs
        templateUrl: 'componentes/menutop/menu.tpl.html',
        restrict: 'E',
        scope: {
            menu: '='
        }
    };
    return directive;
    function controller($scope, $auth) {
        var vm = this;

        vm.isAuthenticated = function() {
            return $auth.isAuthenticated();
        };
    }
}
/**
 *
 */
angular
    .module('app.core')
    .directive('portalListadocategorias', categorias);
function categorias() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/listadocategorias/categorias.tpl.html',
        restrict: 'E',
        scope: {
            menu: '='
        }
    };
    return directive;
    function controller($scope) {
        //$scope.genres = [];
        //ShowService.get($scope.menu.id).then(function(response){
        //    $scope.genres = response.genres;
        //});
    }
}
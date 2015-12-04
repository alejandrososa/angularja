/**
 * 
 */
angular
    .module('app.core')
    .directive('portalEtiquetas', etiquetas);
function etiquetas() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/etiquetas/etiquetas.tpl.html',
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
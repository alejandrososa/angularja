/**
 * 
 */
angular
    .module('app.core')
    .directive('portalGaleria', galeria);
function galeria() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/galeria/galeria.tpl.html',
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
/**
 * 
 */
angular
    .module('app.core')
    .directive('portalPiedepagina', pie);
function pie() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/piedepagina/pie.tpl.html',
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
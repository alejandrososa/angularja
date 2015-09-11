/**
 * 
 */
angular
    .module('app.core')
    .directive('portalQuienesomos', texto);
function texto() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/quienesomos/quienesomos.tpl.html',
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
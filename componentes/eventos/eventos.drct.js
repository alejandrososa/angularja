/**
 * 
 */
angular
    .module('app.core')
    .directive('portalEventos', evento);
function evento() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/eventos/eventos.tpl.html',
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
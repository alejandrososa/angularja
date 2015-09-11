/**
 * 
 */
angular
    .module('app.core')
    .directive('portalMenuinferior', menu);
function menu() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/menuinferior/menu.tpl.html',
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
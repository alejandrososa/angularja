/**
 * 
 */
angular
    .module('app.core')
    .directive('portalMenu', menu);
function menu() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/menu/menu.tpl.html',
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
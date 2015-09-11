/**
 * 
 */
angular
    .module('app.core')
    .directive('portalMenutop', menu);
function menu() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/menutop/menu.tpl.html',
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
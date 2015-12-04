/**
 * 
 */
angular
    .module('app.coreoficina')
    .directive('cmsBarraSuperior', menu);
function menu() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'secciones/oficina/html/directivas/header/header.tpl.html',
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
/**
 * 
 */
angular
    .module('app.core')
    .directive('portalComentarios', comentario);
function comentario() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/comentarios/comentarios.tpl.html',
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
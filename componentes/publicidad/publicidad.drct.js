/**
 * 
 */
angular
    .module('app.core')
    .directive('portalPublicidad', publicidad);
function publicidad() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: function(elem, attr){
            return 'componentes/publicidad/espacio.'+attr.posicion+'.tpl.html';
            //return 'componentes/publicidad/espacio.'+scope.posicion+'.tpl.html';
        },
        	
        //'componentes/publicidad/publicidad.tpl.html',
        restrict: 'E',
        scope: {
            posicion: '='
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
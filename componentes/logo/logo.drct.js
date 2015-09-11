/**
 * 
 */
angular
    .module('app.core')
    .directive('portalLogo', logo);
function logo() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/logo/logo.tpl.html',
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
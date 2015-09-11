/**
 * 
 */
angular
    .module('app.core')
    .directive('portalSlider', slider);
function slider() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/slider/slider.tpl.html',
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
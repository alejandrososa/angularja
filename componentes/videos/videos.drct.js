/**
 * 
 */
angular
    .module('app.core')
    .directive('portalVideos', video);
function video() {  //ShowService
    var directive = {
        controller: controller,
        templateUrl: 'componentes/videos/videos.tpl.html',
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
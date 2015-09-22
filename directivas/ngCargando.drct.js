angular
    .module('app.core')
    .directive('ngCargando', ngCargando);
/*
function ngCargando() {
    return {
        link: function (scope, element) {
            scope.$on("ajax-start", function () {
                element.show();
            });
            scope.$on("ajax-stop", function () {
                element.hide();
            });
        }
    };
};

*/

function ngCargando($rootScope) {
  return {
    restrict: 'E',
    //templateUrl: "src/templates/rotatingPlaneSpinner.html",
    template: "<div ng-show='isRouteLoading' class='loading-indicator'>" +
    "<div class='loading-indicator-body'>" +
    "<h3 class='loading-title'>Cargando...</h3>" +
    "<div class='spinner'><div class='three-dots-row-spinner'></div></div>" +
    "</div>" +
    "</div>",
    replace: true,
    
    
    link: function(scope, elem, attrs) {
      scope.isRouteLoading = false;

      $rootScope.$on('$routeChangeStart', function() {
        scope.isRouteLoading = true;
      });
      $rootScope.$on('$routeChangeSuccess', function() {
        scope.isRouteLoading = false;
      });
    }
  }
};

/**
 * 
 */
angular
    .module('app.coreoficina')
    .directive('cmsPiePagina', cmsFooter);
function cmsFooter() {  //ShowService
    var directive = {
        controller: controller,
        controllerAs: 'vm',
        bindToController: true,
        templateUrl: 'secciones/oficina/html/componentes/footer/footer.tmpl.html',
        restrict: 'E',
        scope: {
            toolbar: '=?toolbar'
        }
    };
    return directive;

    function controller(triSettings, triLayout) {
        var vm = this;
        vm.name = triSettings.name;
        vm.date = new Date();
        vm.layout = triLayout.layout;
        vm.toolbar = vm.toolbar;
        vm.version = triSettings.version;
    }
}
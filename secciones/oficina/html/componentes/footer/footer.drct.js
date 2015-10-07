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
        //bindToController: true,
        templateUrl: 'secciones/oficina/html/componentes/footer/footer.tmpl.html',
        restrict: 'E',
        scope: {
            //clase: '='
        }
    };
    return directive;

    function controller(triSettings, triLayout) {
        var vm = this;

        console.log('--');
        //console.log($element.attr('md-theme'));
        console.log('--');

        vm.name = triSettings.name;
        vm.date = new Date();
        vm.layout = triLayout.layout;
        //vm.toolbar = vm.clase;
        vm.version = triSettings.version;
    }
}
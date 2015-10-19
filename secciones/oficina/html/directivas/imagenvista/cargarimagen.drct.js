/**
 * 
 */
angular
    .module('app.coreoficina')
    .directive('cmsCargarArchivo', menu);
function menu() {  //ShowService
    var directive = {
        controller: controller,
        controllerAs: 'vm',
        templateUrl: 'secciones/oficina/html/directivas/imagenvista/cargar.tpl.html',
        restrict: 'E',
        scope: {
            //menu: '='
        }
    };
    return directive;
    function controller(FileUploader) {
        var vm = this;
        var uploader = vm.uploader = new FileUploader({
            url: 'upload.php'
        });

        // FILTERS

        uploader.filters.push({
            name: 'imageFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        });

        var controller = vm.controller = {
            isImage: function(item) {
                var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
            }
        };
    }
}
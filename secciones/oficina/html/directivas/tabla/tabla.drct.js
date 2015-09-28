/**
 * 
 */
angular
    .module('app.coreoficina')
    .directive('cmsTabla', tabla);
function tabla() {
    var directive = {
        controller: controller,
        controllerAs: 'vm',
        bindToController: true,
        templateUrl: 'secciones/oficina/html/directivas/tabla/tabla.tpl.html',
        restrict: 'E',
        scope: {
            datosproveedor: '='
        }
    };
    return directive;

    function controller($scope, $rootScope, $q, $location, $auth, $log, toastr, $window){

        var vm = this;

        var _columnas = [];

        vm.tblContenido = vm.tblColumnas = vm.tblBuscar = [];
        vm.tblContenido = 'datos' in vm.datosproveedor ? vm.datosproveedor.datos : null;
        vm.tblColumnas  = 'columnas' in vm.datosproveedor ? vm.datosproveedor.columnas : null
        vm.tblColumnasMostrar  = 'columnasMosrtar' in vm.datosproveedor ? vm.datosproveedor.columnasMosrtar : null
        vm.tblNumColumnas = Object.keys(vm.tblColumnas).length;
        vm.tblAcciones  = 'acciones' in vm.datosproveedor ? vm.datosproveedor.acciones : false;
        vm.tblsortType  = 'pordefecto' in vm.datosproveedor ? vm.datosproveedor.pordefecto : '';
        vm.tblsortReverse = 'ordenAsc' in vm.datosproveedor ? vm.datosproveedor.ordenAsc : false;
        vm.tblIdentidad = 'identidad' in vm.datosproveedor ? vm.datosproveedor.identidad : '';
        vm.tblServicio = angular.isDefined(vm.datosproveedor.servicio) ? vm.datosproveedor.servicio : null;

        var Servicio = vm.tblServicio;

        //para definir el # de columnas
        if(vm.tblAcciones == true){
            vm.tblNumColumnas = vm.tblNumColumnas + 1;
        }

        //Mostrar todas las columnas si no se especifican
        if(angular.isArray(vm.tblColumnasMostrar)){
            _columnas = vm.tblColumnasMostrar;
        }else{
            angular.forEach(vm.tblColumnas, function(va, ke) {
                _columnas.push(va.key);
            });
        }

        console.log(_columnas);

        vm.tblVerColumna = function(columna){
            var resultado = false;
            if(columna != ''){
                resultado = _columnas.indexOf(columna) != -1 ? true : false;
            }
            return resultado;
        }

        try{
            vm.editar = function(id){
                console.log(id);
                if(id){
                    $location.path('/admin/'+ vm.tblIdentidad +'/'+ id +'/editar/');
                }
            }

            vm.eliminar = function(id){
                Servicio.eliminar(id);
                console.log('eliminar en directiva');
            }
        } catch (err){
            console.log(err.name + ': "' + err.message +  '" en directiva tabla.');
        }

        console.log(vm.tblNumColumnas);
    }
}
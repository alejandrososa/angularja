/**
 * Created by Alejandro on 20/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .filter('reemplazarespacios',function() {
        return function(input) {
            if (input) {
                return input.replace(/\s+/g, '-');
            }
        }
    })
    .directive('reemplazarespacioss', function(Usuarios) {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function(scope, element, attrs, ngModel) {
                element.bind('blur', function (e) {
                    if (!ngModel || !element.val()) return;
                    var campo = scope.$eval(attrs.reemplazarespacioss);
                    var valor = element.val();
                    /*
                    scope.$watch(angular.element('#'+campo.campo), function(value) {
                        console.log(value);
                        //updateTime();
                    });
                    */
                    //console.log(valor);
                    //console.log(campo.titulo);
                }); //fin link
            }
        };
    })

    .controller('InicioController', function ($scope, $rootScope, PageValues, $cookieStore,
                                                $q, $location, $auth, $log, toastr, $window, FileUploader,
                                                $routeParams, Paginas, Categorias, _datos, _existe,
                                                triLayout, $mdDialog, flowFactory,
                                                $timeout) {

        angular.isUndefinedOrNull = function(val) {
            return angular.isUndefined(val) || val === null
        }

        var vm = this;

        // we need to use the scope here because otherwise the expression in md-is-locked-open doesnt work
        $scope.layout = triLayout.layout; //eslint-disable-line
        vm.layout = triLayout.layout; //eslint-disable-line



        vm.vista = $auth.isAuthenticated();
        vm.menu = $rootScope.menu;

        if (!$auth.isAuthenticated()) {
            $location.path('/login');
        }

        var pagina = angular.isDefined(_datos) ? _datos : {};
        var paginainit = {
            metapalabras : typeof pagina.metapalabras === undefined  || pagina.metapalabras === null ? [] : pagina.metapalabras,
            configuración :  pagina.configuracion == '' ? {slider: []} : pagina.configuracion,
            slider : []
        };

        vm.pagina = angular.equals({}, pagina) ? paginainit : pagina;

        //vm.pagina.configuracion = pagina.configuracion == '' ? paginainit.configuración : pagina.configuracion;
        vm.pagina.autor = Utilidades.LocalStorage.getIdUsuarioActual();

        vm.targets = [];
        vm.editor = [];
        vm.datosproveedor = {};

        vm.existePortada = angular.isDefined(_existe) ? _existe.existe : false;
        vm.idPortada = angular.isDefined(_existe) ? _existe.id : false;


        //fix propiedad vacia metapalabras
        //vm.pagina.slider = {};
        //vm.pagina.metapalabras = angular.isDefined(pagina) ? pagina.metapalabras : [];
        //vm.pagina.configuracion = angular.isDefined(pagina) ? pagina.configuracion : {};



        vm.menus = [];
        vm.enlaces = [];
        vm.enlace = {};
        vm.categorias = [];
        vm.categoriaDefault = 'principal';

        Categorias.todos().then(function(datos){
            if(angular.isDefined(datos) && datos.status == 200){
                vm.categorias = datos.data;
            }
        });




        vm.idUsuario = ($routeParams.id) ? parseInt($routeParams.id) : 0;
        vm.botonTexto = (vm.idUsuario > 0) ? 'Actualizar' : 'Agregar';
        vm.tituloVista = (vm.idUsuario > 0) ? 'Actualizar Enlace' : 'Agregar Enlace';
        vm.tipo = (vm.idUsuario > 0) ? true : false;


        vm.editor = [
            ['undo','redo'],
            ['p','bold','italics','ul','ol','quote','clear'],
            ['h2','h3','h4'],
            ['justifyLeft','justifyCenter','justifyRight'], //justifyFull
            ['insertLink', 'insertVideo'],
            ['html']
        ];


        vm.readonly = false;
        //console.log('id usuario:' + Utilidades.LocalStorage.getIdUsuarioActual());



        ///imagen
        var _name = 'defecto.jpg';
        vm.procesarArchivo = {
            getImagen: function(nombre){
                var slider = [];
                var archivo = arguments.length ? (_name = nombre) : _name;
                slider.push(archivo);
                //vm.configuracion.slider = slider;
                console.log(archivo);
                console.debug(slider);
            }
        }
        var uploader = vm.uploader = new FileUploader({});

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

        ///slider
        vm.sliders = angular.isDefined(vm.pagina.configuración) &&
                        angular.isArray(vm.pagina.configuración.slider) ?
                        vm.pagina.configuración.slider :{};

        //vm.autoloadImagenes = function($flow)
        var resultado = [];
        angular.forEach(pagina, function(value, key) {
            if(key == 'configuracion') {

                this.push(value.slider);

                angular.forEach(value.slider, function(imagen, key) {
                    console.log(imagen);
                    //$flow.addFile(imagen);

                    //this.push(value.file);
                });

            }
        }, resultado);

        console.log(resultado);

        var imagen = {
            flowObj:"slider_0.jpg",
            name:"slider_0.jpg",
            ruta:"C:/xampp/htdocs/angularja/assets/archivos/portada_slider",
            type:"image/jpeg",
            size:511693
        }



        var r = new Flow();
        r.addFile(imagen);
        r.upload();
        //var fl = new FlowFile(r, imagen);


        vm.laimagen = r;

        console.log(vm.laimagen);

        vm.midemo = function($files, $event, $flow){
            var resultado = [];
            angular.forEach($files, function(value, key) {
                console.log(value);
                this.push(value.file);
            }, resultado);

            vm.pagina.slider = resultado;

            //console.debug(resultado);
            //console.debug($files);
            //console.debug($flow);
        }


        ///fin slider





        //dataprovider
        vm.datosproveedor = {
            servicio: Paginas,
            identidad : 'pagina',
            titulo: 'Listado de paginas',
            categoria: vm.categoriaDefault,
            //datos : vm.contenido, //vm.usuarios,
            //columnas : vm.columns,//vm.columnas,
            pordefecto: 'nombre',
            acciones: true,
            ordenAsc: false
        };

        //acciones
        vm.editar = function (frm) {
            if (frm) {
                var resultado = Paginas.actualizar(vm.enlace);
                $log.info(resultado);
            }
        }

        vm.cancelar = function($event) {
            $rootScope.$broadcast('cancelar', $event);
        }

        vm.agregar = function agregar($event) {
            $rootScope.$broadcast('agregar', $event);
        }

        vm.actualizardatos = function actualizardatos() {
            //vm.tablacontenido = [];
            //Paginas.todos(vm.categoriaDefault).then(function(datos){
              //  if(angular.isDefined(datos)){
               //     vm.tblcontenido = datos.resultado;
                //}
            ///});

            //console.log(vm.tablacontenido);
        }
/*
        vm.getPaginas = function(){
            //return $timeout(function() {
            //console.log(vm.categoriaDefault);
            Paginas.todos(vm.categoriaDefault).then(function(datos){
                if(angular.isDefined(datos.resultado)){
                    vm.menus = datos.resultado;
                    vm.tblcontenido = datos.resultado;
                }else{
                    vm.menus = [];
                    vm.tblcontenido = [];
                }
            });
            //}, 650);
        }

*/



    });
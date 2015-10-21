/**
 * Created by Alejandro on 20/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .directive('usuarioDatoUnico', function(Usuarios) {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function(scope, element, attrs, ngModel) {
                element.bind('blur', function (e) {
                    if (!ngModel || !element.val()) return;
                    var campo = scope.$eval(attrs.usuarioDatoUnico);
                    var valor = element.val();

                    Usuarios.existedatousuario(campo.propiedad, valor)
                        .then(function (existe) {
                            //aseguramos que el valor no ha cambiado
                            //desde la llamada realizada
                            if (valor == element.val()) {
                                ngModel.$setValidity('unico', existe);
                            }
                        }, function () {
                            //Probably want a more robust way to handle an error
                            //For this demo we'll set unique to true though
                            ngModel.$setValidity('unico', true);
                        });
                }); //fin link

            }
        };
    })
    .filter('custom', function () {
        return function (input, search) {
            if (!input) return input;
            if (!search) return input;
            var expected = ('' + search).toLowerCase();
            var result = {};
            angular.forEach(input, function (value, key) {
                var actual = ('' + value).toLowerCase();
                if (actual.indexOf(expected) !== -1) {
                    result[key] = value;
                }
            });
            return result;
        }
    })
    .controller('UsuariosController', function ($scope, $rootScope, PageValues, $cookieStore,
                                                $q, $location, $auth, $log, toastr, $window,
                                                $routeParams, Usuarios, _datos,
                                                triLayout, $mdDialog) {

        var vm = this;

        // we need to use the scope here because otherwise the expression in md-is-locked-open doesnt work
        $scope.layout = triLayout.layout; //eslint-disable-line
        vm.layout = triLayout.layout; //eslint-disable-line


        vm.vista = $auth.isAuthenticated();
        vm.menu = $rootScope.menu;

        if (!$auth.isAuthenticated()) {
            $location.path('/login');
        }


        vm.usuario = {};
        vm.usuarios = [];

        vm.idUsuario = ($routeParams.id) ? parseInt($routeParams.id) : 0;
        vm.botonTexto = (vm.idUsuario > 0) ? 'Actualizar' : 'Agregar';
        vm.tituloVista = (vm.idUsuario > 0) ? 'Actualizar Usuario' : 'Agregar Usuario';
        vm.tipo = (vm.idUsuario > 0) ? true : false;

        //usuarios
        vm.usuarios = angular.isDefined(_datos.data) ? _datos.data.resultado : {};

        //usuario
        vm.usuario = {
            id: _datos.id,
            imagen: _datos.imagen,
            usuario: _datos.usuario,
            nombre: _datos.nombre,
            apellidos: _datos.apellidos,
            correo: _datos.correo,
            tel: _datos.telefono,
            direccion: _datos.direccion,
            ciudad: _datos.ciudad,
            pais: _datos.pais
        };



        vm.columns = [
            {
                title: '',
                field: 'imagen',
                sortable: false,
                filter: 'tableImage'
            },/*{
                title: 'Id',
                field: 'id',
                sortable: true
            },*/{
                title: 'Usuario',
                field: 'usuario',
                sortable: true
            },{
                title: 'Correo',
                field: 'correo',
                sortable: true
            },{
                title: 'Telefono',
                field: 'telefono',
                sortable: true
            },{
                title: 'Fecha',
                field: 'fechacreado',
                sortable: true,
                filter: 'tablaFecha'
            },];
        vm.tblcontenido = [];


        /*if(angular.isDefined(vm.usuarios)){
            angular.forEach(vm.usuarios, function(d){

                console.log(angular.isString(d.imagen) && d.imagen != '' ? RUTA_IMAGENES + d.imagen : d.imagen);

                vm.tblcontenido.push({
                    imagen: angular.isString(d.imagen) && d.imagen != '' ? RUTA_IMAGENES + d.imagen : d.imagen,
                    id: d.id,
                    usuario: d.usuario,
                    correo: d.correo,
                    telefono: d.telefono,
                    fechacreado: d.fechacreado
                });

            });
        }*/



        //dataprovider
        vm.datosproveedor = {
            servicio: Usuarios,
            identidad : 'usuario',
            titulo: 'Listado de Usuarios',
            //datos : vm.contenido, //vm.usuarios,
            columnas : vm.columns,//vm.columnas,
            columnasMosrtar : vm.columnasMostrar,
            pordefecto: 'nombre',
            acciones: true,
            ordenAsc: false
        };








        //acciones
        vm.editar = function (frmValido) {
            if (frmValido) {
                var resultado = Usuarios.actualizar(vm.usuario);
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
            vm.tablacontenido = [];
            Usuarios.todos().then(function(datos){
                if(angular.isDefined(datos)){
                    vm.tblcontenido = datos.data.resultado;
                }
            });
        }


        //observadores

        $scope.$on('cancelar', function( ev ){
            $location.path('/admin/usuarios');
        });

        $scope.$on('agregar', function( ev ){
            $mdDialog.show({
                templateUrl: 'secciones/oficina/usuarios/dialogo.tpl.html',
                targetEvent: ev,
                controllerAs: 'vm',
                controller:  DialogController,
            }).then(function(usuario) {
                //vm.persona.push(usuario);
                vm.usuario = usuario;
                //vm.tblcontenido.push(usuario);
                var resultado = Usuarios.crear(usuario);
                var nuevousuario;

                vm.actualizardatos();
            });

            function DialogController($scope, $mdDialog, FileUploader) {
                var vm = this;
                vm.cancelar = cancelar;
                vm.ocultar = ocultar;
                vm.usuario = {};




                ///imagen
                var _name = 'defecto.jpg';
                vm.procesarArchivo = {
                    getImagen: function(nombre){
                        var archivo = arguments.length ? (_name = nombre) : _name;
                        vm.usuario.archivo = archivo;
                        console.log(archivo);
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


                //crop imagen
                //TODO
                /*
                $scope.myImage='';
                $scope.myCroppedImage='';
                vm.myImage='';
                vm.myCroppedImage='';
                $scope.$watch('vm.usuario.archivo', function () {
                    console.log(vm.usuario.archivo);
                    if(angular.isDefined(vm.usuario.archivo)){
                        vm.myImage=vm.usuario.archivo._file.name;
                    }

                    $scope.$apply(function($scope){
                        $scope.myImage=vm.usuario.archivo;
                        console.log($scope.myImage);
                    });
                });

                var handleFileSelect=function(evt) {
                    var file=evt.currentTarget.files[0];
                    var reader = new FileReader();
                    reader.onload = function (evt) {
                        $scope.$apply(function($scope){
                            $scope.myImage=evt.target.result;
                            console.log(evt.target.result)
                        });
                    };
                    reader.readAsDataURL(file);
                };
                var demo = function(evt){
                    console.log('cambio');
                }
                //angular.element(document.querySelector('#fileInput2')).on('change',handleFileSelect);
                angular.element(document.querySelector('#fileInput2')).on('change',demo);
                */
                //fin crop imagen



                ///fin imagen



                /////////////////////////

                function ocultar() {
                    $mdDialog.hide(vm.usuario);
                }

                function cancelar() {
                    $mdDialog.cancel();
                }

            }
        });




    });
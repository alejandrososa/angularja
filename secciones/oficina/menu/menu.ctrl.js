/**
 * Created by Alejandro on 20/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('MenuController', function ($scope, $rootScope, PageValues, $cookieStore,
                                                $q, $location, $auth, $log, toastr, $window,
                                                $routeParams, Menu, _datos,
                                                triLayout, $mdDialog,
                                                $timeout) {

        var vm = this;

        // we need to use the scope here because otherwise the expression in md-is-locked-open doesnt work
        $scope.layout = triLayout.layout; //eslint-disable-line
        vm.layout = triLayout.layout; //eslint-disable-line


        vm.vista = $auth.isAuthenticated();
        vm.menu = $rootScope.menu;

        if (!$auth.isAuthenticated()) {
            $location.path('/login');
        }

        vm.menus = [];
        vm.categoriasMenu = {};
        vm.categoriaDefault = 'principal';

        Menu.categorias().then(function(datos){
            if(angular.isDefined(datos)){
                vm.categoriasMenu = datos.data.resultado;
            }
        });

        Menu.todos(vm.categoriaDefault).then(function(datos){
            if(angular.isDefined(datos)){
                vm.menus = datos.resultado;
            }
        });


        vm.getMenu = function(){
            //return $timeout(function() {
            console.log(vm.categoriaDefault);
                Menu.todos(vm.categoriaDefault).then(function(datos){
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



        //observadores
        var id_categoria;
        $scope.$watch('vm.categoriaSeleccionada', function (newValue, oldValue) {
            if(!oldValue) {
                id_categoria = vm.categoriaDefault;
            }

            if(newValue !== oldValue) {
                vm.categoriaDefault = newValue;
            }

            if(!newValue) {
                vm.categoriaDefault = id_categoria;
            }

            vm.getMenu();
        });























/*

        vm.usuario = {};
        vm.usuarios = [];

        vm.idUsuario = ($routeParams.id) ? parseInt($routeParams.id) : 0;
        vm.botonTexto = (vm.idUsuario > 0) ? 'Actualizar' : 'Agregar';
        vm.tituloVista = (vm.idUsuario > 0) ? 'Actualizar Usuario' : 'Agregar Usuario';
        vm.tipo = (vm.idUsuario > 0) ? true : false;

        //usuarios



*/


        vm.columns = [
            {
                title: 'Id',
                field: 'id',
                sortable: false
            },{
                title: 'Nombre',
                field: 'nombre',
                sortable: true
            },{
                title: 'Enlace',
                field: 'enlace',
                sortable: true
            },{
                title: 'Categoria',
                field: 'categoria',
                sortable: true
            },{
                title: 'Total',
                field: 'hijos',
                sortable: false
                //filter: 'tablaFecha'
            },];
        vm.tblcontenido = [];



        //dataprovider
        vm.datosproveedor = {
            servicio: Menu,
            identidad : 'menu',
            titulo: 'Listado de enlaces',
            //datos : vm.contenido, //vm.usuarios,
            columnas : vm.columns,//vm.columnas,
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
            //vm.tablacontenido = [];
            //Menu.todos(vm.categoriaDefault).then(function(datos){
              //  if(angular.isDefined(datos)){
               //     vm.tblcontenido = datos.resultado;
                //}
            ///});

            console.log(vm.tablacontenido);
        }


        //observadores

        $scope.$on('cancelar', function( ev ){
            $location.path('/admin/menu');
        });

        $scope.$on('agregar', function( ev ){
            $mdDialog.show({
                templateUrl: 'secciones/oficina/usuarios/dialogo.tpl.html',
                targetEvent: ev,
                controllerAs: 'vm',
                controller:  DialogController,
            }).then(function(usuario) {
                //vm.persona.push(usuario);
                //vm.usuario = usuario;
                //vm.tblcontenido.push(usuario);
                //var resultado = Usuarios.crear(usuario);
                //var nuevousuario;

                vm.actualizardatos();
            });

            function DialogController($mdDialog) {
                var vm = this;
                vm.cancelar = cancelar;
                vm.ocultar = ocultar;
                vm.usuario = {};

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
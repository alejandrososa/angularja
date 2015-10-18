/**
 * Created by Alejandro on 20/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('CategoriasController', function ($scope, $rootScope, PageValues, $cookieStore,
                                                  $q, $location, $auth, $log, toastr, $window,
                                                  $routeParams, Categorias, _datos,
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

        vm.categorias = [];
        vm.categoria = {};
        vm.categoriaDefault = 'principal';
        vm.datosproveedor = {};

        vm.idUsuario = ($routeParams.id) ? parseInt($routeParams.id) : 0;
        vm.botonTexto = (vm.idUsuario > 0) ? 'Actualizar' : 'Agregar';
        vm.tituloVista = (vm.idUsuario > 0) ? 'Actualizar categoria' : 'Agregar Enlace';
        vm.tipo = (vm.idUsuario > 0) ? true : false;

        //enlace
        vm.categoria = {
            id: _datos.id,
            titulo: _datos.titulo,
            slug: _datos.slug
        };

        Categorias.todos().then(function(datos){
            if(angular.isDefined(datos)){
                vm.categorias = datos.resultado;
            }
        });





        vm.columns = [
            /*{
                title: 'Id',
                field: 'id',
                sortable: false
            },*/{
                title: 'Titulo',
                field: 'titulo',
                sortable: true
            },{
                title: 'Slug',
                field: 'slug',
                sortable: true
            }];
        vm.tblcontenido = [];



        //dataprovider
        vm.datosproveedor = {
            servicio: Categorias,
            identidad : 'categoria',
            titulo: 'Listado de categorias',
            categoria: vm.categoriaDefault,
            //datos : vm.contenido, //vm.usuarios,
            columnas : vm.columns,//vm.columnas,
            pordefecto: 'id',
            acciones: true,
            ordenAsc: false
        };

        //acciones
        vm.editar = function (frm) {
            if (frm) {
                var resultado = Categorias.actualizar(vm.categoria);
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
        }

        vm.getCategorias = function(){
            //return $timeout(function() {
            console.log(vm.categoriaDefault);
            Categorias.todos(vm.categoriaDefault).then(function(datos){
                if(angular.isDefined(datos.resultado)){
                    vm.categorias = datos.resultado;
                    vm.tblcontenido = datos.resultado;
                }else{
                    vm.categorias = [];
                    vm.tblcontenido = [];
                }
            });
            //}, 650);
        }


        //observadores

        $scope.$on('cancelar', function( ev ){
            $location.path('/admin/categorias');
        });


        $scope.$on('agregar', function( ev ){
            $mdDialog.show({
                templateUrl: 'secciones/oficina/categorias/dialogo.tpl.html',
                targetEvent: ev,
                controllerAs: 'vm',
                controller:  DialogController,
            }).then(function(categoria) {
                vm.tblcontenido.push(categoria);
                var resultado = Categorias.crear(categoria);

                vm.actualizardatos();
            });

            function DialogController($scope, $mdDialog, Menu) {
                var vm = this;
                vm.cancelar = cancelar;
                vm.ocultar = ocultar;
                vm.actualizar = actualizar;
                vm.query = {
                    filtro: 'principal',
                    tipo:'principal',
                };
                vm.categoria = {};
                vm.categorias = [];

                /////////////////////////

                function actualizar(){
                    Categorias.todos().then(function(datos){
                        vm.categorias = datos.data;
                    });
                }

                function ocultar() {
                    $mdDialog.hide(vm.categoria);
                }

                function cancelar() {
                    $mdDialog.cancel();
                }
            }
        });




    });
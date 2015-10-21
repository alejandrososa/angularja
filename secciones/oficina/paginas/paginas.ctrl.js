/**
 * Created by Alejandro on 20/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('PaginasController', function ($scope, $rootScope, PageValues, $cookieStore,
                                                $q, $location, $auth, $log, toastr, $window,
                                                $routeParams, Paginas, _datos,
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
        vm.enlaces = [];
        vm.enlace = {};
        vm.categoriasPaginas = {};
        vm.categoriaDefault = 'principal';
        vm.targets = []
        vm.datosproveedor = {};

        vm.idUsuario = ($routeParams.id) ? parseInt($routeParams.id) : 0;
        vm.botonTexto = (vm.idUsuario > 0) ? 'Actualizar' : 'Agregar';
        vm.tituloVista = (vm.idUsuario > 0) ? 'Actualizar Enlace' : 'Agregar Enlace';
        vm.tipo = (vm.idUsuario > 0) ? true : false;

        //enlace
        vm.enlace = {
            id: _datos.id,
            nombre: _datos.nombre,
            clase: _datos.clase,
            ruta: _datos.enlace,
            target: _datos.target,
            padre: _datos.padre,
            categoria: _datos.categoria,
            clavecategoria: _datos.clavecategoria,
            idcategoria: _datos.idcategoria,
        };

        //enlaces vista editar
        if(angular.isDefined(vm.enlace.clavecategoria)){
            Paginas.todos().then(function(datos){
                vm.enlaces = datos.resultado;
            });
            console.log(vm.enlaces);
        }

        //targets
        //vm.targets = Paginas.targets();



        Paginas.categorias().then(function(datos){
            if(angular.isDefined(datos)){
                vm.categoriasPaginas = datos.data.resultado;
            }
        });

        Paginas.todos(vm.categoriaDefault).then(function(datos){
            if(angular.isDefined(datos)){
                vm.menus = datos.resultado;
            }
        });





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
            servicio: Paginas,
            identidad : 'menu',
            titulo: 'Listado de paginas',
            categoria: vm.categoriaDefault,
            //datos : vm.contenido, //vm.usuarios,
            columnas : vm.columns,//vm.columnas,
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

            console.log(vm.tablacontenido);
        }

        vm.getPaginas = function(){
            //return $timeout(function() {
            console.log(vm.categoriaDefault);
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


        //observadores
        //select categorias de menu - vista menu
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

            vm.datosproveedor.categoria = vm.categoriaDefault;

            vm.getPaginas();
        });

        $scope.$watch('vm.enlace.padre', function (newValue, oldValue) {
            if(newValue !== oldValue) {
                 Paginas.unico(newValue).then(function(datos){
                    vm.enlace.idcategoria = datos.idcategoria;
                });
            }
        });

        $scope.$on('cancelar', function( ev ){
            $location.path('/admin/paginas');
        });


        $scope.$on('agregar', function( ev ){
            $mdDialog.show({
                templateUrl: 'secciones/oficina/paginas/dialogo.tpl.html',
                targetEvent: ev,
                controllerAs: 'vm',
                controller:  DialogController,
            }).then(function(enlace) {
                vm.tblcontenido.push(enlace);
                var resultado = Paginas.crear(enlace);


                vm.actualizardatos();
            });

            function DialogController($scope, $mdDialog, Paginas) {
                var vm = this;
                vm.cancelar = cancelar;
                vm.ocultar = ocultar;
                vm.actualizar = actualizar;
                vm.query = {
                    filtro: 'principal',
                    tipo:'principal',
                };
                vm.usuario = {};
                vm.categorias = {};
                vm.enlace = {};
                vm.enlaces = [];
                //vm.target = Paginas.targets();

                Paginas.categorias().then(function(datos){
                    if(angular.isDefined(datos)){
                        vm.categorias = datos.data.resultado;
                    }
                });

                Paginas.todos(vm.filtro).then(function(datos){
                    if(angular.isDefined(datos)){
                        vm.enlaces = datos.resultado;
                    }
                });

                //observador
                var id_categoria;
                $scope.$watch('vm.enlace.categoria', function (nuevo, anterior) {
                    if(!anterior) {
                        id_categoria = vm.query.filtro;
                    }

                    if(nuevo !== anterior) {
                        vm.query.filtro = nuevo;
                        vm.query.tipo = nuevo;
                    }

                    if(!nuevo) {
                        vm.query.filtro = id_categoria;
                        vm.query.tipo = id_categoria;
                    }

                    vm.actualizar();
                });

                /////////////////////////

                function actualizar(){
                    vm.query.tipo = vm.enlace.categoria;
                    /*Paginas.buscadorporcategorias(vm.query).then(function(datos){
                        vm.enlaces = datos.data;
                    });*/
                }

                function ocultar() {
                    $mdDialog.hide(vm.enlace);
                }

                function cancelar() {
                    $mdDialog.cancel();
                }
            }
        });




    });
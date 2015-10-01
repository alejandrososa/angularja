/**
 * Created by Alejandro on 20/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('PaginasController', function($scope, $rootScope, PageValues, $cookieStore,
                                             $q, $location, $auth, $log, toastr, $window,
                                             $routeParams, Paginas, _datos) {

        var vm = this;

        vm.vista = $auth.isAuthenticated();
        vm.menu = $rootScope.menu;


        if (!$auth.isAuthenticated()) {
            $location.path('/login');
        }

        vm.idPagina = ($routeParams.id) ? parseInt($routeParams.id) : 0;
        vm.titulo = (vm.idPagina > 0) ? 'Actualizar categoria' : 'Agregar nueva categoria';
        vm.botonTexto = (vm.idPagina > 0) ? 'Actualizar' : 'Agregar';
        vm.tipoProceso = (vm.idPagina > 0) ? true : false;


        vm.paginas = [];
        vm.pagina = {};

        //categorias
        vm.paginas = angular.isDefined(_datos.data) ? _datos.data.resultado : {};

        console.log(_datos);
        //categoria
        vm.pagina = {
            id: _datos.id,
            titulo: _datos.titulo,
            slug: _datos.slug
        };


        vm.columnas =  [
            { "key": "id", "nombre": "id", "style": {"width": "35%"} },
            { "key": "nombre", "nombre": "Nombre", "style": {"width": "50%"} },
            //{ "key": "slug", "nombre": "Slug", "style": {"width": "15%"} },
            { "key": "tipo", "nombre": "Tipo", "style": {"width": "15%"} },
            { "key": "fecha", "nombre": "Fecha", "style": {"width": "15%"} }
        ];

        vm.datosproveedor = {
            servicio: Paginas,
            identidad : 'pagina',
            datos : vm.paginas,
            columnas : vm.columnas,
            pordefecto: 'titulo',
            acciones: true,
            ordenAsc: false,
            demo:"hola mundo"
        };

        //vm.columnas = ['id','nombre','slug','acciones'];

        //acciones
        vm.procesar = function (isValid, tipo) {
            if (!isValid) {
                console.log('no es valido');
                return;
            }

            if (!tipo) {
                vm.crear();
            } else {
                vm.editar()
            }
        }

        vm.crear = function () {
            var resultado = Paginas.crear(vm.pagina);
            $location.path('/admin/paginas');
            //$log.info( resultado);
        }

        vm.editar = function () {
            var resultado = Paginas.actualizar(vm.pagina);
            //$log.info( resultado);
        }

        vm.eliminar = function (id, index) {
            var resultado = Paginas.eliminar(id);
            if (resultado){
                $log.info( index);
                vm.paginas.splice(index, 1);
            }
        }


    });
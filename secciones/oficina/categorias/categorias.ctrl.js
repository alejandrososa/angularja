/**
 * Created by Alejandro on 20/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('CategoriasController', function($scope, $rootScope, PageValues, $cookieStore,
                                             $q, $location, $auth, $log, toastr, $window,
                                             $routeParams, Categorias, _datos) {

        var vm = this;

        vm.vista = $auth.isAuthenticated();
        vm.menu = $rootScope.menu;


        if (!$auth.isAuthenticated()) {
            $location.path('/login');
        }

        vm.idCategoria = ($routeParams.id) ? parseInt($routeParams.id) : 0;
        vm.titulo = (vm.idCategoria > 0) ? 'Actualizar categoria' : 'Agregar nueva categoria';
        vm.botonTexto = (vm.idCategoria > 0) ? 'Actualizar' : 'Agregar';
        vm.tipoProceso = (vm.idCategoria > 0) ? true : false;


        vm.categorias = [];
        vm.categoria = {};

        //categorias
        vm.categorias = angular.isDefined(_datos.data) ? _datos.data.resultado : {};

        console.log(_datos);
        //categoria
        vm.categoria = {
            id: _datos.id,
            titulo: _datos.titulo,
            slug: _datos.slug
        };


        vm.columnas =  [
            { "key": "id", "nombre": "id", "style": {"width": "35%"} },
            { "key": "titulo", "nombre": "Titulo", "style": {"width": "50%"} },
            { "key": "slug", "nombre": "Slug", "style": {"width": "15%"} }
        ];

        vm.datosproveedor = {
            servicio: Categorias,
            identidad : 'categoria',
            datos : vm.categorias,
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
            var resultado = Categorias.crear(vm.categoria);
            $location.path('/admin/categoria');
            //$log.info( resultado);
        }

        vm.editar = function () {
            var resultado = Categorias.actualizar(vm.categoria);
            //$log.info( resultado);
        }

        vm.eliminar = function (id, index) {
            var resultado = Categorias.eliminar(id);
            if (resultado){
                $log.info( index);
                vm.categoria.splice(index, 1);
            }
        }


    });
/**
 * Created by Alejandro on 20/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
    .controller('CategoriasController', function($scope, $rootScope, PageValues, $cookieStore,
                                             $q, $location, $auth, $log, toastr, $window, Categorias) {

        var vm = this;

        vm.vista = $auth.isAuthenticated();
        vm.menu = $rootScope.menu;


        if (!$auth.isAuthenticated()) {
            $location.path('/login');
        }


        vm.usuarios = [];
        vm.tblsortType     = 'name'; // set the default sort type
        vm.tblsortReverse  = false;  // set the default sort order
        vm.tblsearchFish   = '';     //


        vm.hola = vm.usuarios;

        vm.categorias = [{
                id: 1,
                titulo: 'categoria 1',
                slug: 'demo'
            },
            {
                id: 2,
                titulo: 'categoria 2',
                slug: 'demo 2'
            }
        ];

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

    });
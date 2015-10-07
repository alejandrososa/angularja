/**
 * Created by Alejandro on 20/09/2015.
 */
'use strict';
angular
    .module('app.coreoficina')
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
                                                triLayout) {

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
        //vm.tblsortType = 'nombre'; // set the default sort type
        //vm.tblsortReverse = false;  // set the default sort order
        //vm.tblsearchFish = [];     //

        vm.idUsuario = ($routeParams.id) ? parseInt($routeParams.id) : 0;
        vm.botonTexto = (vm.idUsuario > 0) ? 'Actualizar' : 'Agregar';
        vm.tipo = (vm.idUsuario > 0) ? true : false;

        //usuarios
        vm.usuarios = angular.isDefined(_datos.data) ? _datos.data.resultado : {};

        //usuario
        vm.usuario = {
            id: _datos.id,
            usuario: _datos.usuario,
            nombre: _datos.nombre,
            apellidos: _datos.apellidos,
            correo: _datos.correo,
            tel: _datos.telefono,
            direccion: _datos.direccion,
            ciudad: _datos.ciudad,
            pais: _datos.pais
        };

        vm.columns = [{
            title: '',
            field: 'thumb',
            sortable: false,
            filter: 'tableImage'
        },{
            title: 'Name',
            field: 'name',
            sortable: true
        },{
            title: 'Description',
            field: 'description',
            sortable: true
        },{
            title: 'Date of Birth',
            field: 'birth',
            sortable: true
        }];

        vm.contents = [{
            thumb:'assets/plantillas/admin/img/avatars/avatar-1.png',
            name: 'Chris Doe',
            description: 'Developer',
            birth: 'Jun 5, 1994'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-2.png',
            name: 'Ann Doe',
            description: 'Commerce',
            birth: 'Jul 15, 1993'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-3.png',
            name: 'Mark Ronson',
            description: 'Designer',
            birth: 'Jan 27, 1984'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-4.png',
            name: 'Eric Doe',
            description: 'Human Resources',
            birth: 'Feb 3, 1985'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-5.png',
            name: 'John Doe',
            description: 'Commerce',
            birth: 'Sep 5, 1978'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-1.png',
            name: 'George Doe',
            description: 'Media',
            birth: 'Jun 23, 1996'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-2.png',
            name: 'Ann Ronson',
            description: 'Commerce',
            birth: 'Aug 16, 1995'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-3.png',
            name: 'Adam Ronson',
            description: 'Developer',
            birth: 'Jan 7, 1987'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-4.png',
            name: 'Hansel Doe',
            description: 'Social Media',
            birth: 'Feb 13, 1977'
        },{
            thumb:'assets/plantillas/admin/img/avatars/avatar-5.png',
            name: 'Tony Doe',
            description: 'CEO',
            birth: 'Sep 29, 1970'
        }];


        //dataprovider
        vm.columnas =  [
            { "key": "id", "nombre": "Id", "style": {"width": "35%"} },
            //{ "key": "usuario", "nombre": "Usuario", "style": {"width": "50%"} },
            { "key": "nombre", "nombre": "Nombre", "style": {"width": "15%"} },
            { "key": "Correo", "nombre": "Correo", "style": {"width": "50%"} },
            { "key": "Telefono", "nombre": "Telefono", "style": {"width": "15%"} },
        ];
        vm.columnasMostrar = ['uid', 'id', 'nombre','correo', 'telefono'];
        vm.datosproveedor = {
            servicio: Usuarios,
            identidad : 'usuario',
            datos : vm.usuarios,
            columnas : vm.columnas,
            columnasMosrtar : vm.columnasMostrar,
            pordefecto: 'nombre',
            acciones: true,
            ordenAsc: false
        };

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
            var resultado = Usuarios.crear(vm.usuario);
            $location.path('/admin/usuarios');
            //$log.info( resultado);
        }

        vm.editar = function () {
            var resultado = Usuarios.actualizar(vm.usuario);
            //$log.info( resultado);
        }

        vm.eliminar = function (id, index) {
            var resultado = Usuarios.eliminar(id);
            if (resultado){
                $log.info( index);
                vm.usuarios.splice(index, 1);
            }
        }


        /**
         * End sidebar
         */

        $scope.alerts = [{
            type: 'success',
            msg: 'Thanks for visiting! Feel free to create pull requests to improve the dashboard!'
        }, {
            type: 'danger',
            msg: 'Found a bug? Create an issue with as many details as you can.'
        }];

        $scope.addAlert = function () {
            $scope.alerts.push({
                msg: 'Another alert!'
            });
        };

        $scope.closeAlert = function (index) {
            $scope.alerts.splice(index, 1);
        };

    });
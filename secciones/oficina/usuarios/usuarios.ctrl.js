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
    .service('GithubService', Service)

.controller('UsuariosController', function ($scope, $rootScope, PageValues, $cookieStore,
                                                $q, $location, $auth, $log, toastr, $window,
                                                $routeParams, Usuarios, _datos,
                                                triLayout, GithubService) {

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

        console.log(_datos);

        vm.columns = [
            {
            title: '',
            field: 'imagen',
            sortable: false,
            filter: 'tableImage'
            },{
                title: 'Id',
                field: 'id',
                sortable: true
            },{
                title: 'Usuario',
                field: 'usuario',
                sortable: true
            },{
                title: 'Correo',
                field: 'correo',
                sortable: true
            },{
                title: 'Telefono',
                field: 'tel',
                sortable: true
            },{
                title: 'Fecha',
                field: 'fecha',
                sortable: true
            },];

        vm.contenido = [];

        angular.forEach(vm.usuarios, function(d){

            vm.contenido.push({
                imagen: d.imagen,
                id: d.id,
                usuario: d.usuario,
                correo: d.correo,
                tel: d.telefono,
                fecha: d.fechacreado
            });

        });


        //dataprovider
        /*vm.columnas =  [
            { "key": "id", "nombre": "Id", "style": {"width": "35%"} },
            //{ "key": "usuario", "nombre": "Usuario", "style": {"width": "50%"} },
            { "key": "nombre", "nombre": "Nombre", "style": {"width": "15%"} },
            { "key": "Correo", "nombre": "Correo", "style": {"width": "50%"} },
            { "key": "Telefono", "nombre": "Telefono", "style": {"width": "15%"} },
        ];*/
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

        vm.query = {
            filter: '',
            limit: '10',
            order: '-id',
            page: 1
        };
        vm.selected = [];
        vm.filter = {
            options: {
                debounce: 500
            }
        };
        vm.getUsers = getUsers;// vm.contenido;
        vm.removeFilter = removeFilter;

        activate();

        ////////////////

        function activate() {
            var bookmark;
            $scope.$watch('vm.query.filter', function (newValue, oldValue) {
                if(!oldValue) {
                    bookmark = vm.query.page;
                }

                if(newValue !== oldValue) {
                    vm.query.page = 1;
                }

                if(!newValue) {
                    vm.query.page = bookmark;
                }

                vm.getUsers();
            });
        }

        function getUsers() {
            /*GithubService.getUsers(vm.query).then(function(users){
                vm.users = users.data;
            });
            */
        }

        function removeFilter() {
            vm.filter.show = false;
            vm.query.filter = '';

            if(vm.filter.form.$dirty) {
                vm.filter.form.$setPristine();
            }
        }

    });


Service.$inject = ['$http', '$q'];

/* @ngInject */
function Service($http) {
    this.getUsers = getUsers;

    ////////////////

    function getUsers(query) {
        var order = query.order === 'id' ? 'desc':'asc';

        console.log(query);

        /*return $http.get('https://api.github.com/search/users?q='+query.filter+'+repos:%3E10+followers:%3E100&order='+order+'&sort=joined&per_page='+query.limit+'&page='+query.page,
            { headers : {
                'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8'
            }}).
            success(function(data) {
                return data;
            });

            */
    }
}
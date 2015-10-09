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
                field: 'telefono',
                sortable: true
            },{
                title: 'Fecha',
                field: 'fechacreado',
                sortable: true,
                filter: 'tablaFecha'
            },];

        vm.tblcontenido = [];

        console.log(_datos.data.resultado);

        angular.forEach(_datos.data.resultado, function(d){

            vm.tblcontenido.push({
                imagen: d.imagen,
                id: d.id,
                usuario: d.usuario,
                correo: d.correo,
                telefono: d.telefono,
                fechacreado: d.fechacreado
            });

        });


        //dataprovider
        vm.datosproveedor = {
            servicio: Usuarios,
            identidad : 'usuario',
            //datos : vm.contenido, //vm.usuarios,
            columnas : vm.columns,//vm.columnas,
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
        vm.actualizardatos = actualizardatos;
        function actualizardatos() {
            vm.tablacontenido = [];
            Usuarios.todos().then(function(datos){
                    if(angular.isDefined(datos)){
                        console.log(datos);
                        vm.tblcontenido = datos.data.resultado;
                    }
                });
            console.log(vm.tablacontenido);
        }


        //DIALOGO
        //////////
        vm.addTodo = addTodo;
        function addTodo($event) {
            $rootScope.$broadcast('addTodo', $event);
        }
        vm.cancel = cancel;
        vm.hide = hide;
        vm.item = {
            description: '',
            priority: '',
            selected: false
        };

        /////////////////////////

        function hide() {
            $mdDialog.hide(vm.item);
        }

        function cancel() {
            $mdDialog.cancel();
        }


        //
        vm.usuario = {};

        vm.todos = [
            {description: 'Material Design', priority: 'high', selected: true},
        ];
        vm.orderTodos = orderTodos;
        vm.removeTodo = removeTodo;


        //////////////////////////



        function orderTodos(task) {
            switch(task.priority){
                case 'high':
                    return 1;
                case 'medium':
                    return 2;
                case 'low':
                    return 3;
                default: // no priority set
                    return 4;
            }
        }

        function removeTodo(todo){
            for(var i = vm.usuario.length - 1; i >= 0; i--) {
                if(vm.usuario[i] === todo) {
                    vm.usuario.splice(i, 1);
                }
            }
        }

        // watches

        $scope.$on('addTodo', function( ev ){
            $mdDialog.show({
                templateUrl: 'secciones/oficina/usuarios/add-todo-dialog.tmpl.html',
                targetEvent: ev,
                controllerAs: 'vm',
                controller:  function DialogController($mdDialog) {
                    var vm = this;
                    vm.cancel = cancel;
                    vm.hide = hide;
                    vm.usuario = {};

                    /////////////////////////

                    function hide() {
                        $mdDialog.hide(vm.usuario);
                    }

                    function cancel() {
                        $mdDialog.cancel();
                    }
                },

            })
                .then(function(usuario) {
                    //vm.persona.push(usuario);
                    vm.usuario = usuario;
                    //vm.tblcontenido.push(usuario);
                    var resultado = Usuarios.crear(usuario);
                    var nuevousuario;

                    console.log(usuario);
                    /*Usuarios.buscador(usuario.nombre).then(function(datos){
                        console.log(usuario.nombre);
                        if(angular.isDefined(datos)){
                            console.log(datos);
                            vm.tblcontenido.push(datos.data);
                        }
                    });*/
                    vm.actualizardatos();
                    //console.info(resultado)
                });
        });


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
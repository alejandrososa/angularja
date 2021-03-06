/**
 *
 */
'use strict';

angular
    .module('app.rutas', ['ngRoute', 'ngResource', 'ngMessages', 'ngAnimate', 'toastr', 'satellizer','door3.css'])
    .config(config);
//.run(run);

function run ($location, $rootScope, $auth) {
    var routespermission = [
        '/admin',
        '/gracias'
    ];

    $rootScope.vista = false;

    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        if( routespermission.indexOf($location.path()) !=-1){
            if (!$auth.isAuthenticated()) {
                $location.path('/login');
                //$window.location.href = '/login';

                $rootScope.vista = false;
            }
            $rootScope.vista = true;
        }
    });
}

function config ($routeProvider, $locationProvider, $authProvider) {
    $routeProvider.
        when('/', {
            templateUrl: 'secciones/portada/portada.tpl.html',
            controller: 'PortadaController as vm',
            css: {
                href: 'assets/plantillas/solido/css/solido.css',
                bustCache: true
            },
            resolve: {
                _datos: function(Paginas, Contenido) {
                    //carga todos los json antes de la portada
                    Contenido.cargarPortada();
                    return Paginas.obtenerPortada().then(function(datos){
                        return datos.data;
                    });
                },
            }
        })
        .when('/premieres', {
            templateUrl: 'secciones/premieres/premieres.tpl.html',
            controller: 'PremieresController as premieres',
            resolve: {
                shows: function(ShowService) {
                    return ShowService.getPremieres();
                }
            }
        })
        .when('/search', {
            templateUrl: 'sections/search/search.tpl.html',
            controller: 'SearchController as search'
        })
        .when('/search/:query', {
            templateUrl: 'sections/search/search.tpl.html',
            controller: 'SearchController as search'
        })
        .when('/popular', {
            templateUrl: 'sections/popular/popular.tpl.html',
            controller: 'PopularController as popular',
            resolve: {
                shows: function(ShowService) {
                    return ShowService.getPopular();
                }
            }
        })
        .when('/view/:id', {
            templateUrl: 'sections/view/view.tpl.html',
            controller: 'ViewController as view',
            resolve: {
                show: function(ShowService, $route) {
                    return ShowService.get($route.current.params.id);
                }
            }
        })
        .when('/login', {
            templateUrl: 'secciones/login/acceso.tpl.html',
            controller: 'LoginController as acceso',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                esUsuarioAutenticado: esUsuarioAutenticado
            }
        })
        .when('/logout', {
            template: null,
            //controller: 'LogoutController as logout',
            resolve: {
                cerrarSesion: cerrarSesion
            }
        })
        .when('/admin', {
            templateUrl: 'secciones/oficina/admin.tpl.html',
            controller: 'AdminController as vm',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                accesoRestringido: accesoRestringido
            },
            data: {
                layout: {
                    showToolbar: true,
                    footer: true
                }
            }
        })

        //USUARIOS
        .when('/admin/usuarios', {
            templateUrl: 'secciones/oficina/usuarios/usuarios.tpl.html',
            controller: 'UsuariosController as vm',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                accesoRestringido: accesoRestringido,
                _datos: function(Usuarios) {
                    return Usuarios.todos();
                }
            }
        })
        .when('/admin/usuario/:id/editar/', {
            templateUrl: 'secciones/oficina/usuarios/editar.tpl.html',
            controller: 'UsuariosController as vm',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                accesoRestringido: accesoRestringido,
                _datos: function(Usuarios, $route) {
                    return Usuarios.unico($route.current.params.id);
                }
            }
        })

        //MENU
        .when('/admin/menu', {
            templateUrl: 'secciones/oficina/menu/menus.tpl.html',
            controller: 'MenuController as vm',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                accesoRestringido: accesoRestringido,
                _datos: function(Menu) {
                    return Menu.unico('principal');
                }
            }
        })
        .when('/admin/menu/:id/editar/', {
            templateUrl: 'secciones/oficina/menu/editar.tpl.html',
            controller: 'MenuController as vm',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                accesoRestringido: accesoRestringido,
                _datos: function(Menu, $route) {
                    return Menu.unico($route.current.params.id);
                }
            }
        })

        //CATEGORIAS
        .when('/admin/categorias', {
            templateUrl: 'secciones/oficina/categorias/categorias.tpl.html',
            controller: 'CategoriasController as vm',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                accesoRestringido: accesoRestringido,
                _datos: function(Categorias) {
                    return Categorias.todos();
                }
            }
        })
        .when('/admin/categoria/:id/editar/', {
            templateUrl: 'secciones/oficina/categorias/editar.tpl.html',
            controller: 'CategoriasController as vm',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                accesoRestringido: accesoRestringido,
                _datos: function(Categorias, $route) {
                    return Categorias.unico($route.current.params.id);
                }
            }
        })

        //PAGINAS
        .when('/admin/paginas', {
            templateUrl: 'secciones/oficina/paginas/paginas.tpl.html',
            controller: 'PaginasController as vm',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                accesoRestringido: accesoRestringido,
                _datos: function(Paginas) {
                    return Paginas.todos();
                }
            }
        })
        .when('/admin/pagina/inicio', {
            templateUrl: 'secciones/oficina/inicio/inicio.tpl.html',
            controller: 'InicioController as vm',
            css: {
                href: 'assets/plantillas/admin/css/admin.css',
                bustCache: true
            },
            resolve: {
                accesoRestringido: accesoRestringido,
                _datos: function(Paginas) {
                    return Paginas.obtenerPortada().then(function(datos){
                        //console.log(datos);
                        return datos.data;
                    });
                },
                _existe: function(Paginas) {
                    return Paginas.existePortada().then(function(datos){
                        return datos.data.resultado;
                    });
                },
            }
        })
        .when('/admin/pagina/crear', {
            templateUrl: 'secciones/oficina/paginas/crear.tpl.html',
            controller: 'PaginasController as vm',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                accesoRestringido: accesoRestringido,
                _datos: function() {
                    var datos = {};
                    return datos;
                }
            }
        })
        .when('/admin/pagina/:id/editar', {
            templateUrl: 'secciones/oficina/paginas/editar.tpl.html',
            controller: 'PaginasController as vm',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                accesoRestringido: accesoRestringido,
                _datos: function(Paginas, $route) {
                    return Paginas.unico($route.current.params.id);
                }
            }
        })
        .when('/admin/opciones', {
            templateUrl: 'secciones/oficina/opciones/opciones.tpl.html',
            controller: 'AdminController as vmAdmin',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                accesoRestringido: accesoRestringido
            }
        })
        .when('/admin/opciones', {
            templateUrl: 'secciones/oficina/opciones/opciones.tpl.html',
            controller: 'AdminController as vmAdmin',
            css: ['assets/plantillas/admin/css/admin.css','assets/plantillas/solido/css/solido.css'],
            resolve: {
                accesoRestringido: accesoRestringido
            }
        })




        //comodines

        .when('/:categoria', {
            templateUrl: 'secciones/categoria/categoria.tpl.html',
            controller: 'CategoriaController as categoria',
            css: {
                href: 'assets/plantillas/solido/css/solido.css',
                bustCache: true
            },
            resolve: {
                _categoria: existeCategoria
            }
        })
        .when('/:categoria/:slug', {
            templateUrl: 'secciones/detalle/detalle.tpl.html',
            controller: 'DetalleController as detalle',
            css: {
                href: 'assets/plantillas/solido/css/solido.css',
                bustCache: true
            },
            resolve: {
                _detalle: existeDetalle
            }
        })

        .otherwise({
            //redirectTo: '/'
            templateUrl: 'secciones/error/error.tpl.html',
            controller: 'ErrorController as vmError',
            css: {
                href: 'assets/plantillas/solido/css/solido.css',
                bustCache: true
            }
        });





    //$locationProvider.html5Mode(true);
    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });

    function esUsuarioAutenticado($q, $auth) {
        var deferred = $q.defer();
        if ($auth.isAuthenticated()) {
            deferred.reject();
        } else {
            deferred.resolve();
        }
        return deferred.promise;
    }

    function accesoRestringido($q, $location, $auth, $window) {
        var deferred = $q.defer();
        if (!$auth.isAuthenticated()) {
            $location.path('/login');
            //$window.location.href = '/login';
        } else {
            deferred.resolve();
        }
        return deferred.promise;
    }

    function cerrarSesion($q, $location, $auth, toastr, $log, $window) {
        var deferred = $q.defer();

        //if (!$auth.isAuthenticated()) { return; }

        $log.info('La sesión se ha cerrado');
        $auth.logout()
            .then(function() {
                toastr.info('La sesion se ha cerrado');
                //$window.location.href = '/';
                $location.path('/');
            });

    }

    function existeCategoria(Paginas, $route, $location) {
        return Paginas.todostipo($route.current.params.categoria).then(function(datos){
            if(angular.isDefined(datos.data.resultado)){
                if(!datos.data.resultado.existe){
                    $location.path("/");
                }
                var oListado = {};
                oListado.id = datos.data.resultado.id;
                oListado.titulo = datos.data.resultado.titulo;
                oListado.lista = datos.data.resultado.listado;
                return oListado;
            }
        });
    }

    function existeDetalle(Paginas, $route, $location) {
        return Paginas.detalle($route.current.params.categoria, $route.current.params.slug).then(function(datos){
            if(angular.isDefined(datos.data.resultado)){
                if(!datos.data.resultado.existe){
                    $location.path("/");
                }

                return datos.data.resultado;
            }
        });
    }




    $authProvider.facebook({
        clientId: '657854390977827'
    });

    $authProvider.google({
        clientId: '804614980883-ad2056ce2i8boiardcib2s6nkqrmkgbh.apps.googleusercontent.com '
    });

    $authProvider.github({
        clientId: '0ba2600b1dbdb756688b'
    });

    $authProvider.linkedin({
        clientId: '77cw786yignpzj'
    });

    $authProvider.instagram({
        clientId: '799d1f8ea0e44ac8b70e7f18fcacedd1'
    });

    $authProvider.yahoo({
        clientId: 'dj0yJmk9SDVkM2RhNWJSc2ZBJmQ9WVdrOWIzVlFRMWxzTXpZbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD0yYw--'
    });

    $authProvider.twitter({
        url: '/auth/twitter'
    });

    $authProvider.live({
        clientId: '000000004C12E68D'
    });

    $authProvider.twitch({
        clientId: 'qhc3lft06xipnmndydcr3wau939a20z'
    });

    $authProvider.oauth2({
        name: 'foursquare',
        url: '/auth/foursquare',
        clientId: 'MTCEJ3NGW2PNNB31WOSBFDSAD4MTHYVAZ1UKIULXZ2CVFC2K',
        redirectUri: window.location.origin || window.location.protocol + '//' + window.location.host,
        authorizationEndpoint: 'https://foursquare.com/oauth2/authenticate'
    });


}

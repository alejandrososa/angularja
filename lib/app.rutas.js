/**
 * 
 */
'use strict';

angular
.module('app.rutas', ['ngRoute', 'ngResource', 'ngMessages', 'ngAnimate', 'toastr', 'satellizer'])
.config(config);

function config ($routeProvider, $locationProvider, $authProvider) {
$routeProvider.
    when('/', {
        templateUrl: 'secciones/portada/portada.tpl.html',
        controller: 'PortadaController as portada'
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
        templateUrl: 'secciones/admin/admin.tpl.html',
        controller: 'LoginController as login',
        resolve: {
            accesoRestringido: accesoRestringido
        }
    })



    .otherwise({
        //redirectTo: '/'
        templateUrl: 'secciones/error/error.tpl.html',
        controller: 'ErrorController as vmError',
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

    function accesoRestringido($q, $location, $auth) {
        var deferred = $q.defer();
        if ($auth.isAuthenticated()) {
            deferred.resolve();
        } else {
            $location.path('/login');
        }
        return deferred.promise;
    }

    function cerrarSesion($q, $location, $auth, toastr, $log) {
        var deferred = $q.defer();

        if (!$auth.isAuthenticated()) { return; }

        $log.info('La sesión se ha cerrado');
        $auth.logout()
            .then(function() {
                toastr.info('La sesion se ha cerrado');
                $location.path('/');
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
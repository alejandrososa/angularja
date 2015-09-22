'use strict';
angular
    .module('app.config', [])
    .config(configs) //;
	.run(runs);

function configs($httpProvider) {
    var interceptor = function($location, $log, $q, $rootScope) {

        function error(response) {
            if (response.status === 401) {
                $log.error('You are unauthorised to access the requested resource (401)');
            } else if (response.status === 404) {
                $log.error('The requested resource could not be found (404)');
            } else if (response.status === 500) {
                $log.error('Internal server error (500)');
            }
            return $q.reject(response);
        }
        function success(response) {
            return response;
        }
        return function(promise) {
            return promise.then(success, error);
        }
    };
    $httpProvider.interceptors.push(interceptor);
}

function runs($rootScope, PageValues, $log) {

        var peticion = 0;

        var mostrarCargando = function () {
            if (!peticion) {
                $log.info('entro mostrar cargando');
                $rootScope.$broadcast("ajax-start");
            }
            peticion++;
        }
        var ocultarCargando = function () {
            peticion--;
            if (!peticion) {
                $log.info('salio mostrar cargando');
                $rootScope.$broadcast("ajax-stop");
            }
        }

    $rootScope.$on('$routeChangeStart', function() {
        mostrarCargando();
        PageValues.loading = true;
    });
    $rootScope.$on('$routeChangeSuccess', function() {
        ocultarCargando();
        PageValues.loading = false;
    });
}
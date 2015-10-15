'use strict';+

/*
 * Contains a service to communicate with the TRACK TV API
 */
angular
    .module('app.servicios')
    .constant('API_URL', 'http://ja.dev/api/')
    .constant('IMG_URL', 'http://ja.dev/assets/images/')
    .factory('Menu', servicio);

function servicio($http, API_URL, $log, toastr) {
    var data = {
        'seleccionar': seleccionar,
        'todos': todos,
        'categorias': categorias,
        'buscador': buscador,
        'principal': menuPrincipal,
    };

    function ejecutar(tipo, url, params) {
        var requestUrl = API_URL + url;
        
        angular.forEach(params, function(value, key){
            requestUrl = requestUrl + '&' + key + '=' + value;
        });

        return $http({
            'url': requestUrl,
            'method': 'GET',
            'headers': {
                'Content-Type': 'application/json'
            },
            'cache': true
        }).then(function(response){
            return response.data;
        }).catch(dataServiceError);
    }

    function menuPrincipal(){
        return $http.get(API_URL + 'getMenu', {}).then(function (datos) {
            return datos.data;
         });
    }

    function seleccionar(tipo){
        return $http.get(API_URL + 'getMenu?tipo='+tipo, {}).then(function (datos) {
            return datos.data;
        });
    }
    function todos(tipo){
        return $http.get(API_URL + 'getTodosEnlacesMenu?tipo='+tipo, {}).then(function (datos) {
            return datos.data;
        });
    }

    function categorias(){
        return $http.get(API_URL + 'getMenuCategorias', {});
    }

    function buscador(query){
        return $http.post(API_URL + 'buscadorUsuarios', {filtro:query});
    }

    return data;

    function dataServiceError(errorResponse) {
        $log.error('XHR Failed for Contenido');
        $log.error(errorResponse);
        return errorResponse;
    }
}
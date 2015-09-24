'use strict';+

/*
 * Contains a service to communicate with the TRACK TV API
 */
angular
    .module('app.servicios')
    .constant('API_URL', 'http://ja.dev/api/')
    .factory('Usuarios', servicio);

function servicio($http, API_URL, $log) { 
    var data = {
        'one': one,
        'getUsuarios': getUsuarios,
        //'getUltimosArticulos': getUltimosArticulos,
        //'getUltimasNoticias': getUltimasNoticias,
        //'getArticulosCategoria': getArticulosCategoria,
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
            console.log(response.data);
            return response.data;
        }).catch(dataServiceError);
    }

    function one(id){
        /*return $http.post(API_URL + 'getUsuario', {id:id}).then(function (datos) {
            console.log(datos.data);
            return datos.data; //status.data;
        });*/

        return $http.get(API_URL + 'getUsuario?id='+id, {}).then(function (datos) {
            console.log(datos.data);
            return datos.data; //status.data;
         });

        /*
        return ejecutar('get','getUsuario?id='+id, {}).then(function(data) {
            return data;
        });
        */
    }

    function getUsuarios(){
        return $http.get(API_URL + 'getUsuarios', {}).then(function (datos) {
            console.log(datos.data.resultado);
            return datos.data.resultado; //status.data;
        });
        /*
        return ejecutar('get', 'getUsuarios', {}).then(function (datos) {
            console.log(datos.resultado);
            return datos.resultado; //status.data;
        });
        */
    }
    
    function getUltimosArticulos(cantidad){
    	return ejecutar('get', 'getUltimosArticulos?cantidad='+ cantidad, {});
    }
    
    function getUltimasNoticias(cantidad){
    	return ejecutar('get', 'getUltimasNoticias?cantidad='+ cantidad, {});
    }
    
    function getArticulosCategoria(cantidad){
    	return ejecutar('get', 'getArticulosCategoria?cantidad='+ cantidad, {});
    }
    
    /*
    function getPremieres() {
        //Get first day of the current month
        var date = new Date();
        date.setDate(1);
        return makeRequest('discover/tv', {'first_air_date.gte': moment(date).format('DD-MM-YYYY'), append_to_response: 'genres'}).then(function(data){
            return data.results;
        });
    }
    function get(id) {
        return makeRequest('tv/' + id, {});
    }
    function getCast(id) {
        return makeRequest('tv/' + id + '/credits', {});
    }
    function search(query) {
        return makeRequest('search/tv', {query: query}).then(function(data){
            return data.results;
        });
    }
    function getPopular() {
        return makeRequest('tv/popular', {}).then(function(data){
            return data.results;
        });
    }
    */
    return data;

    function dataServiceError(errorResponse) {
        $log.error('XHR Failed for Contenido');
        $log.error(errorResponse);
        return errorResponse;
    }
}
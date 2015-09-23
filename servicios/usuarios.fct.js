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
        'getUsuarios': getUsuarios,
    	'getUltimosArticulos': getUltimosArticulos,
    	'getUltimasNoticias': getUltimasNoticias,
    	'getArticulosCategoria': getArticulosCategoria,
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
    function getUsuarios(){
        return ejecutar('get', 'getUsuariosModelohoy', {});
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
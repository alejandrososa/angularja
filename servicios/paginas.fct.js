'use strict';+

/*
 * Contains a service to communicate with the TRACK TV API
 */
angular
    .module('app.servicios')
    .constant('API_URL', 'http://ja.dev/api/')
    .constant('IMG_URL', 'http://ja.dev/assets/images/')
    .factory('Paginas', categoria);

function categoria($http, API_URL, $log, toastr) {
    var data = {
        'buscador': buscador,
        'unico': unico,
        'todos': todos,
        'crear': crear,
        'eliminar': eliminar,
        'actualizar': actualizar,
        'categorias': categorias,
        'demo': demo
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

    function buscador(query){
        return $http.post(API_URL + 'buscadorMenu', {filtro:query, tipo: query.tipo});
    }

    function unico(id){
        return $http.post(API_URL + 'unicaPagina', {id:id}).then(function (datos) {
            return datos.data;
         });
    }

    function todos(){
        return $http.get(API_URL + 'todasPaginas', {});
            /*.then(function (datos) {
            return datos.data.resultado;
        });*/
    }

    function actualizar(categoria){
        return $http.put(API_URL + 'actualizarPagina', {
            id: categoria.id,
            categoria:categoria,
            transformRequest: angular.indentity,
            headers: { 'Content-Type': undefined }
        }).then(function (datos) {
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function crear(pagina){
        //pagina.fechacreado = moment().format("YYYY-MM-DD hh:mm:ss");
        console.log('enviado');
        return $http.post(API_URL + 'crearPagina', {
            pagina:pagina,
            transformRequest: angular.indentity,
            headers: { 'Content-Type': undefined }
        }).then(function (datos) {
            toastr.success(datos.data.mensaje);
            console.log(datos);
            return datos.data;
        });
    }

    function eliminar(id){
        return $http.delete(API_URL + 'eliminarPagina?id='+id, {}).then(function (datos) {
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function guardarImagen(){
        return $http.post(API_URL + 'eliminarPagina?id='+id, {
            transformRequest: angular.indentity,
            headers: { 'Content-Type': undefined }
        }).then(function (datos) {
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function categorias(){
        return $http.get(API_URL + 'getPaginasCategorias', {});
    }

    function demo(id){
        $log.info('desde servicio id'+id);
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
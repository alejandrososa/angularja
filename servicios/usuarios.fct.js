'use strict';+

/*
 * Contains a service to communicate with the TRACK TV API
 */
angular
    .module('app.servicios')
    .constant('API_URL', 'http://ja.dev/api/')
    .constant('IMG_URL', 'http://ja.dev/assets/images/')
    .factory('Usuarios', servicio);

function servicio($http, API_URL, $log, toastr) {
    var data = {
        'unico': unico,
        'todos': todos,
        'buscador': buscador,
        'crear': crear,
        'actualizar': actualizar,
        'eliminar': eliminar,
        'existedatousuario': existedatousuario
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

    function unico(id){
        return $http.post(API_URL + 'unicoUsuario', {id:id}).then(function (datos) {
            return datos.data;
         });
    }

    function todos(){
        return $http.get(API_URL + 'todosUsuarios', {});
            /*.then(function (datos) {
            return datos.data.resultado;
        });*/
    }

    function buscador(query){
        return $http.post(API_URL + 'buscadorUsuarios', {filtro:query});
    }

    function actualizar(usuario){
        return $http.put(API_URL + 'actualizarUsuario', {
            id: usuario.id,
            usuario:usuario,
            transformRequest: angular.indentity,
            headers: { 'Content-Type': undefined }
        }).then(function (datos) {
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function crear(usuario){
        var fd = new FormData();
        if(angular.isDefined(usuario.archivo._file)) {
            fd.append('file', usuario.archivo._file);
        }

        for (var key in usuario) {
            if(key != 'archivo') {
                fd.append('usuario[usuario]['+ key +']', usuario[key]);
            }
        }

        return $http.post(API_URL + 'crearUsuario', fd, {
            //file: fd,
            //id: usuario.id,
            //usuario:usuario,
            transformRequest: angular.indentity,
            headers: { 'Content-Type': undefined }
        }).then(function (datos) {
            console.log(datos);
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function eliminar(id){
        return $http.delete(API_URL + 'eliminarUsuario?id='+id, {}).then(function (datos) {
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function existedatousuario(clave, valor){
        return $http.post(API_URL + 'existeDatoUsuario', {clave:clave, valor:valor}).then(function (datos) {
            return datos.data.existe;
        });
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
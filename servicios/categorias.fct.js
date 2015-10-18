'use strict';+

/*
 * Contains a service to communicate with the TRACK TV API
 */
angular
    .module('app.servicios')
    .constant('API_URL', 'http://ja.dev/api/')
    .constant('IMG_URL', 'http://ja.dev/assets/images/')
    .factory('Categorias', categoria);

function categoria($http, API_URL, $log, toastr) {
    var data = {
        'buscador': buscador,
        'unico': unico,
        'todos': todos,
        'crear': crear,
        'eliminar': eliminar,
        'actualizar': actualizar,
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
        return $http.post(API_URL + 'buscadorCategorias', {filtro:query, tipo: query.tipo});
    }

    function unico(id){
        return $http.post(API_URL + 'unicaCategoria', {id:id}).then(function (datos) {
            return datos.data;
         });
    }

    function todos(){
        return $http.get(API_URL + 'todasCategorias', {});
            /*.then(function (datos) {
            return datos.data.resultado;
        });*/
    }

    function actualizar(categoria){
        console.log(categoria);
        return $http.put(API_URL + 'actualizarCategoria', {
            id: categoria.id,
            categoria:categoria,
            transformRequest: angular.indentity,
            headers: { 'Content-Type': undefined }
        }).then(function (datos) {
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function crear(categoria){
        return $http.post(API_URL + 'crearCategoria', {
            id: categoria.id,
            categoria:categoria,
            transformRequest: angular.indentity,
            headers: { 'Content-Type': undefined }
        }).then(function (datos) {
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function eliminar(id){
        return $http.delete(API_URL + 'eliminarCategoria?id='+id, {}).then(function (datos) {
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function demo(id){
        $log.info('desde servicio id'+id);
    }

    return data;

    function dataServiceError(errorResponse) {
        $log.error('XHR Failed for Contenido');
        $log.error(errorResponse);
        return errorResponse;
    }
}
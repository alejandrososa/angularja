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
        'unico': unico,
        'todos': todos,
        'todostipo': todostipo,
        'categorias': categorias,
        'buscador': buscador,
        'buscadorporcategorias': buscadorPorCategoria,
        'principal': menuPrincipal,
        'crear': crear,
        'actualizar': actualizar,
        'eliminar': eliminar,
        'targets':targets
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

    function unico(id){
        return $http.post(API_URL + 'unicoEnlace', {id:id}).then(function (datos) {
            return datos.data;
        });
    }

    function todos(){
        return $http.get(API_URL + 'getTodosEnlaces', {}).then(function (datos) {
            return datos.data;
        });
    }

    function todostipo(tipo){
        return $http.get(API_URL + 'getTodosEnlacesMenu?tipo='+tipo, {}).then(function (datos) {
            return datos.data;
        });
    }

    function categorias(){
        return $http.get(API_URL + 'getMenuCategorias', {});
    }

    function buscador(query){
        return $http.post(API_URL + 'buscadorMenu', {filtro:query, tipo: query.tipo});
    }
    function buscadorPorCategoria(query){
        return $http.post(API_URL + 'buscadorMenuCategoria', {filtro:query, tipo: query.tipo});
    }

    function crear(enlace){
        return $http.post(API_URL + 'crearEnlace', {
            id: enlace.id,
            enlace:enlace,
            transformRequest: angular.indentity,
            headers: { 'Content-Type': undefined }
        }).then(function (datos) {
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function actualizar(enlace){
        return $http.put(API_URL + 'actualizarEnlace', {
            id: enlace.id,
            enlace:enlace,
            transformRequest: angular.indentity,
            headers: { 'Content-Type': undefined }
        }).then(function (datos) {
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function eliminar(id){
        return $http.delete(API_URL + 'eliminarEnlace?id='+id, {}).then(function (datos) {
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function targets(){
        return [
            { clave:'_self', valor: 'Interno' },
            { clave:'_blank', valor:'Externo' },
            { clave:'_top', valor:'Top' }
        ];
    }

    return data;

    function dataServiceError(errorResponse) {
        $log.error('XHR Failed for Contenido');
        $log.error(errorResponse);
        return errorResponse;
    }
}
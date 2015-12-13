'use strict';+

/*
 * Contains a service to communicate with the TRACK TV API
 */
angular
    .module('app.servicios')
    .constant('API_URL', 'http://ja.dev/api/')
    .constant('IMG_URL', 'http://ja.dev/assets/images/')
    .factory('Paginas', paginas);

function paginas($http, API_URL, $log, toastr) {
    var data = {
        'buscador': buscador,
        'unico': unico,
        'detalle': detalle,
        'todos': todos,
        'todostipo':todostipo,
        'crear': crear,
        'eliminar': eliminar,
        'actualizar': actualizar,
        //'categorias': categorias,

        'existePortada': existePortada,
        'guardarPortada': guardarPortada,
        'obtenerPortada': obtenerPortada,

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

    function detalle(categoria, slug){
        return $http.post(API_URL + 'detallePagina', {categoria:categoria, slug:slug});
    }

    function todos(){
        return $http.get(API_URL + 'todasPaginas', {});
    }

    function todostipo(categoria){
        return $http.post(API_URL + 'PaginasPorCategoria', {categoria:categoria});
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
        pagina.fechacreado = moment().format("YYYY-MM-DD hh:mm:ss");
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



    function existePortada(){
        return $http.get(API_URL + 'existePortada', {});
    }

    function obtenerPortada(){
        return $http.get(API_URL + 'obtenerPortada', {});
    }

    function guardarPortada(pagina){
        var fd = new FormData();
        console.log(pagina.slider);
        if(angular.isDefined(pagina.slider)) {
            for (var i = 0; i < pagina.slider.length; i++) { // Loop all files
                fd.append('file' + i, pagina.slider[i]); // Create an append() method, one for each file dropped
            }
            //fd.append('file', pagina.slider);
        }

        fd.append("pagina", JSON.stringify(pagina));
        /*for (var key in pagina) {
            if(key != 'slider') {
                //fd.append('pagina['+ key +']', pagina[key]);
            }
        }*/

        return $http.post(API_URL + 'guardarPortada', fd, {
            //file: fd,
            transformRequest: angular.indentity,
            headers: { 'Content-Type': undefined, processData: false }
        }).then(function (datos) {
            toastr.success(datos.data.mensaje);
            return datos.data;
        });
    }

    function guardarPortada2(pagina){
        pagina.fechacreado = moment().format("YYYY-MM-DD hh:mm:ss");
        return $http.post(API_URL + 'guardarPortada', {
            pagina:pagina,
            transformRequest: angular.indentity,
            headers: { 'Content-Type': undefined }
        }).then(function (datos) {
            toastr.success(datos.data.mensaje);
            console.log(datos);
            return datos.data;
        });
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
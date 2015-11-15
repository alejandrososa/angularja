/**
 * 
 */
angular
    .module('app.core')
    .directive('portalListadoarticulos', listadoarticulos );
function listadoarticulos(Contenido) {  //ShowService
    var directive = {
        controller: controller,
        controllerAs: 'list',
        //bindToController: true, //required in 1.3+ with controllerAs
        //templateUrl: 'componentes/listadoarticulos/articulos.tpl.html',
        templateUrl: function(elem, attr){
            return 'componentes/listadoarticulos/'+attr.categoria+'.tpl.html';
        },
        restrict: 'E',
        scope: {
            categoria: '@categoria',
			proveedor: '=?proveedor'
        },
        
    };
    return directive;
    
    function controller(Contenido) {
    	
    	var vm = this;
    	vm.datos = {};
    	
    	switch(vm.categoria) {
	        case "articulos":
	        	Contenido.getUltimosArticulos(5).then(function(respuesta){
	        		vm.datos = respuesta;
	        	});
	        	
	            break;
	        case "noticias":
	        	Contenido.getUltimasNoticias(5).then(function(respuesta){
	        		vm.datos = respuesta;
	        	});
	        	
	            break;
	        default:
		        Contenido.getUltimosArticulos(5).then(function(respuesta){
	        		vm.datos = respuesta;    		
	        	});
	        	
	    }
    	
    };
}
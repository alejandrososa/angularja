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
        bindToController: true, //required in 1.3+ with controllerAs
        //templateUrl: 'componentes/listadoarticulos/articulos.tpl.html',
        templateUrl: function(elem, attr){
            return 'componentes/listadoarticulos/'+attr.categoria+'.tpl.html';
        },
        restrict: 'E',
        scope: {
            categoria: '@categoria',
			proveedor: '=?proveedor',
			cantidad: '@cantidad',
			estilo: '@estilo',
        },
        
    };
    return directive;
    
    function controller(Contenido) {
    	
    	var vm = this;
    	vm.datos = {};

		console.log(vm.categoria);

		/*
    	
    	switch(vm.cantidad) {
			case "articulosrecientes":
				Contenido.getUltimosArticulos(vm.cantidad).then(function(respuesta){
					console.log(1);
					vm.datos = respuesta;
				});
				break;
	        case "articulos":
	        	Contenido.getUltimosArticulos(vm.cantidad).then(function(respuesta){
					console.log(2);
	        		vm.datos = respuesta;
	        	});
	            break;
	        case "noticias":
	        	Contenido.getUltimasNoticias(5).then(function(respuesta){
					console.log(3);
	        		//vm.datos = respuesta;
	        	});
	            break;
	        default:
		        Contenido.getUltimosArticulos(1).then(function(respuesta){
					console.log(4);
					console.log(vm.categoria);
					console.log(vm.estilo);
	        		vm.datos = respuesta;    		
	        	});
	        	
	    }*/
    	
    };
}
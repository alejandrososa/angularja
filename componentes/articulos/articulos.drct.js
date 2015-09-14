/**
 * 
 */
angular
    .module('app.core')
    .directive('portalArticulos', articulos );
function articulos(Contenido) {  //ShowService
    var directive = {
        controller: controller,
        controllerAs: 'vm',
        bindToController: true, //required in 1.3+ with controllerAs
        //templateUrl: 'componentes/listadoarticulos/articulos.tpl.html',
        templateUrl: function(elem, attr){
        	//var tpl = attr.estilo || 'defecto';
            return 'componentes/articulos/'+attr.estilo+'.tpl.html';
        },
        restrict: 'E',
        scope: {
            categoria: '@categoria',
            estilo: '@estilo'
        },
        
    };
    return directive;
    
    function controller(Contenido) {
    	
    	var vm = this;
    	vm.datos = vm.datos2 = {};
    	
    	switch(vm.categoria) {
	        case "articulos":
	        	Contenido.getArticulosCategoria(4).then(function(respuesta){
	        		vm.datos = respuesta;
					vm.datos2 = respuesta;
	        	});
	        	
	            break;
	        case "noticias":
	        	Contenido.getUltimasNoticias(5).then(function(respuesta){
	        		vm.datos = respuesta;
					vm.datos2 = respuesta;
	        	});
	        	
	            break;
	        case "eventos":
	        	Contenido.getArticulosCategoria(5).then(function(respuesta){
	        		vm.datos = respuesta;
					vm.datos2 = respuesta;
	        	});
	        	
	            break;
			case "musica":
				Contenido.getArticulosCategoria(2).then(function(respuesta){
					vm.datos = respuesta;
				});

				break;

			case "recientes":
				Contenido.getArticulosCategoria(3).then(function(respuesta){
					vm.datos = respuesta;
				});

				break;

	        default:
		        Contenido.getUltimosArticulos(3).then(function(respuesta){
	        		vm.datos = respuesta;
					vm.datos2 = respuesta;
	        	});
	        	
	    }
    	
    };
}
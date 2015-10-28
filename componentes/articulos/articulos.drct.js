/**
 * 
 */
angular
    .module('app.core')
	.filter('limiteTexto', limitetexto)
	.directive('imagen', verificaImagen)
	.directive('portalArticulos', articulos );

function articulos(Contenido, $filter) {  //ShowService
    var directive = {
        controller: controller,
        controllerAs: 'vm',
        bindToController: true, //required in 1.3+ with controllerAs
        //templateUrl: 'componentes/listadoarticulos/articulos.tpl.html',
        templateUrl: function(elem, attr){
        	var tpl = attr.estilo || 'defecto';
            return 'componentes/articulos/'+attr.estilo+'.tpl.html';
        },
        restrict: 'E',
        scope: {
			proveedor: '=?proveedor',
            categoria: '=?categoria',
            estilo: '@?estilo',
			demo: '=?demo',
			paginacion: '@?paginacion'
        },
        
    };
    return directive;
    
    function controller(Contenido, $scope, $attrs) {

		var vm = this;
		vm.datos = vm.datos2 = {};


		if(angular.isDefined(vm.categoria)) {

			switch (vm.categoria) {
				case "articulos":
					Contenido.getArticulosCategoria(4).then(function (respuesta) {
						vm.datos = respuesta;
						vm.datos2 = respuesta;
					});

					break;
			}
		}

		//vista categoria
		if (angular.isDefined(vm.proveedor)) {
			vm.titulo = vm.proveedor.titulo;
			vm.datos = vm.proveedor.datos;
		}

		//vista general
		if (angular.isUndefined(vm.proveedor)) {
			switch (vm.categoria) {
				case "articulos":
					Contenido.getArticulosCategoria(4).then(function (respuesta) {
						vm.datos = respuesta;
						vm.datos2 = respuesta;
					});

					break;
				case "noticias":
					Contenido.getUltimasNoticias(5).then(function (respuesta) {
						vm.datos = respuesta;
						vm.datos2 = respuesta;
					});

					break;
				case "eventos":
					Contenido.getArticulosCategoria(5).then(function (respuesta) {
						vm.datos = respuesta;
						vm.datos2 = respuesta;
					});

					break;
				case "musica":
					Contenido.getArticulosCategoria(2).then(function (respuesta) {
						vm.datos = respuesta;
					});

					break;

				case "recientes":
					Contenido.getArticulosCategoria(3).then(function (respuesta) {
						vm.datos = respuesta;
					});

					break;

				default:
					Contenido.getUltimosArticulos(3).then(function (respuesta) {
						vm.datos = respuesta;
						vm.datos2 = respuesta;
					});
			}
		}

		//paginacion
		vm.contenido = [];
		vm.paginas = [];
		// init page size if not set to default
		vm.pageSize = angular.isUndefined($attrs.pageSize) ? 0 : $attrs.pageSize;

		// init page if not set to default
		vm.page = angular.isUndefined($attrs.page) ? 0 : $attrs.page;


		vm.refresh = function (resetPage) {
			if (resetPage === true) {
				vm.page = 0;
			}
			vm.datos = vm.datos; //$filter('orderBy')(vm.datos, '-id', true);
		};

		vm.totalItems = function () {
			return vm.datos.length;
		};

		vm.numberOfPages = function () {
			return Math.ceil(vm.datos.length / vm.pageSize);
		};

		vm.pageStart = function () {
			return (vm.page * vm.pageSize);
		};

		vm.pageEnd = function () {
			var end = ((vm.page + 1) * vm.pageSize);
			if (end > vm.datos.length) {
				end = vm.datos.length;
			}
			return end;
		};

		vm.goToPage = function (page) {
			vm.page = page;
		};

		for (var i=1; i<vm.numberOfPages(); i++) {
			vm.paginas.push(i);
		}


		if(vm.estilo == 'listadocategoria') {
			$scope.$watch('vm.page + vm.pageSize', function () {
				var begin = vm.pageStart();
				var end = vm.pageEnd();
				vm.contenido = angular.isDefined(vm.datos) ? vm.datos.slice(begin, end) : [];
			});
		}
	}
}

function verificaImagen($q) {
	return {
		restrict: 'A',
		link: function(scope, element, attrs) {
			attrs.$observe('ngSrc', function (ngSrc) {
				var deferred = $q.defer();
				var image = new Image();
				image.onerror = function () {
					deferred.resolve(false);
					element.attr('src', '/assets/plantillas/solido/images/photos/image-29.jpg'); // set default image
				};
				image.onload = function () {
					deferred.resolve(true);
				};
				image.src = ngSrc;
				return deferred.promise;
			});
		}
	};
}

function limitetexto () {
	return function (texto, palabra, max, final) {
		if (!texto) return '';

		max = parseInt(max, 10);
		if (!max) return texto;
		if (texto.length <= max) return texto;

		texto = texto.substr(0, max);
		if (palabra) {
			var lastspace = texto.lastIndexOf(' ');
			if (lastspace != -1) {
				texto = texto.substr(0, lastspace);
			}
		}

		return texto + (final || '...');
	};
}
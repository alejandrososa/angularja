
    'use strict';

    angular
        .module('app.coreoficina')
        .directive('cmsDataTabla', cmsTabla);



    /* @ngInject */
    function cmsTabla($filter) {
        var directive = {
            restrict: 'E',
            scope: {
                datosproveedor: '=',
                columns: '=',
                contents: '=',
                filters: '='
            },
            link: link,
            //bindToController: true,
            controller: controller,
            controllerAs: 'vm',
            templateUrl: 'secciones/oficina/html/componentes/table/tabla.tpl.html'
        };
        return directive;

        function controller($scope, $location, $mdDialog){
            var vm = this;
            vm.query = {
                tipo:'',
                filter: '',
                limit: '10',
                order: '-id',
                page: 1
            };
            vm.selected = [];
            vm.filter = {
                options: {
                    debounce: 500
                }
            };
            vm.getDatos = getDatos;
            vm.limpiaFiltro = limpiaFiltro;
            vm.accionEditar = accionEditar;
            vm.accionBorrar = accionBorrar;

            //vm.tblContenido = 'datos' in vm.datosproveedor ? vm.datosproveedor.datos : null;
            //vm.tblColumnas  = 'columnas' in vm.datosproveedor ? vm.datosproveedor.columnas : null
            vm.tblIdentidad = angular.isDefined($scope.datosproveedor.identidad) ? $scope.datosproveedor.identidad : null;
            vm.tblAcciones = angular.isDefined($scope.datosproveedor.acciones) ? $scope.datosproveedor.acciones : false;
            vm.tblCategoria = angular.isDefined($scope.datosproveedor.categoria) ? $scope.datosproveedor.categoria : null;
            vm.tblServicio = angular.isDefined($scope.datosproveedor.servicio) ? $scope.datosproveedor.servicio : null;
            vm.tblTitulo = angular.isDefined($scope.datosproveedor.titulo) ? $scope.datosproveedor.titulo : 'Listado';
            var Servicio = vm.tblServicio;

            activate();

            ////////////////

            function activate() {
                var bookmark;

                vm.query.tipo = vm.tblCategoria;

                $scope.$watch('vm.query.filter', function (newValue, oldValue) {
                    if(!oldValue) {
                        bookmark = vm.query.page;
                    }

                    if(newValue !== oldValue) {
                        vm.query.page = 1;
                    }

                    if(!newValue) {
                        vm.query.page = bookmark;
                    }

                    vm.getDatos();
                });
            }

            function getDatos() {
                Servicio.buscador(vm.query.filter).then(function(datos){
                    //vm.tablacontenido = users.data;
                    $scope.contents = datos.data;
                });
            }

            function limpiaFiltro() {
                vm.filter.show = false;
                vm.query.filter = '';

                if(vm.filter.form.$dirty) {
                    vm.filter.form.$setPristine();
                }
            }

            function accionEditar(id) {
                $location.path('/admin/'+ vm.tblIdentidad + '/'+ id +'/editar/');
            }

            function accionBorrar(ev, id, index){
                var confirm = $mdDialog.confirm()
                    .title('Seguro que desea eliminar?')
                    .content('Los datos eliminados no poduen recuperarse.')
                    .ariaLabel('Lucky day')
                    .targetEvent(ev)
                    .ok('Aceptar')
                    .cancel('Cancelar');
                $mdDialog.show(confirm).then(function() {
                    Servicio.eliminar(id);
                    $scope.contents.splice(index, 1);
                }, function() {
                    vm.status = 'no'+id;
                });

            }
        }

        function link($scope, $element, attrs, scope) {
            var sortableColumns = [];
            var activeSortColumn = null;
            var activeSortOrder = false;

            var vm = this;



            // init page size if not set to default
            $scope.pageSize = angular.isUndefined(attrs.pageSize) ? 0 : attrs.pageSize;

            // init page if not set to default
            $scope.page = angular.isUndefined(attrs.page) ? 0 : attrs.page;

            // make an array of all sortable columns
            angular.forEach($scope.columns, function(column) {
                if(column.sortable) {
                    sortableColumns.push(column.field);
                }
            });

            $scope.refresh = function(resetPage) {
                if(resetPage === true) {
                    $scope.page = 0;
                }
                $scope.contents = $filter('orderBy')($scope.contents, activeSortColumn, activeSortOrder);
            };

            // if we have sortable columns sort by first by default
            if(sortableColumns.length > 0) {
                // sort first column by default
                activeSortOrder = false;
                activeSortColumn = sortableColumns[0];
                $scope.refresh();
            }

            $scope.sortClick = function(field) {
                if(sortableColumns.indexOf(field) !== -1) {
                    if(field === activeSortColumn) {
                        activeSortOrder = !activeSortOrder;
                    }
                    activeSortColumn = field;
                    $scope.refresh();
                }
            };

            $scope.showSortOrder = function(field, orderDown) {
                return field === activeSortColumn && activeSortOrder === orderDown;
            };

            $scope.headerClass = function(field) {
                var classes = [];
                if(sortableColumns.indexOf(field) !== -1) {
                    classes.push('sortable');
                }
                if(field === activeSortColumn) {
                    classes.push('sorted');
                }
                return classes;
            };

            $scope.cellContents = function(column, content) {
                if(angular.isDefined(column.filter)) {
                    return $filter(column.filter)(content[column.field]);
                }
                else {
                    return content[column.field];
                }
            };

            $scope.totalItems = function() {
                return $scope.contents.length;
            };

            $scope.numberOfPages = function() {
                return Math.ceil($scope.contents.length / $scope.pageSize);
            };

            $scope.pageStart = function() {
                return ($scope.page * $scope.pageSize) + 1;
            };

            $scope.pageEnd = function() {
                var end = (($scope.page + 1) * $scope.pageSize);
                if(end > $scope.contents.length) {
                    end = $scope.contents.length;
                }
                return end;
            };

            $scope.goToPage = function (page) {
                $scope.page = page;
            };
        }
    }
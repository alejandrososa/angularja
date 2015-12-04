/**
 * 
 */
angular
    .module('app.coreoficina')
    .directive('cmsLogin', menu);
function menu() {  //ShowService
    var directive = {
        controller: controller,
        controllerAs: 'vm',
        bindToController: true,
        templateUrl: 'secciones/oficina/html/componentes/login/form.tpl.html',
        restrict: 'E',
        scope: {
            menu: '=?menu'
        }
    };
    return directive;
    function controller($scope, $rootScope, $cookieStore,
                        $q, $location, $auth, $log, toastr, $window, triSettings){

        var vm = this;

        vm.socialLogins = [{
            icon: 'fa fa-twitter',
            color: '#5bc0de',
            url: '#'
        },{
            icon: 'fa fa-facebook',
            color: '#337ab7',
            url: '#'
        },{
            icon: 'fa fa-google-plus',
            color: '#e05d6f',
            url: '#'
        },{
            icon: 'fa fa-linkedin',
            color: '#337ab7',
            url: '#'
        }];
        vm.triSettings = triSettings;
        // create blank user variable for login form
        vm.user = {
            email: '',
            password: ''
        };

        vm.volver = function(){
            $location.path('/');
        }

        vm.login = function() {

            if(angular.isDefined(vm.persona)) {
                $auth.login(vm.persona)
                    .then(function() {
                        toastr.success('You have successfully signed in');
                        $location.path('/admin/');
                        //$window.location.href = '/admin/';
                    })
                    .catch(function(response) {
                        console.clear();
                        $log.reset;
                        $log.warn('No esta autorizado');
                        toastr.error(response.data.message, response.status); //response.data.message
                        $location.path('/login');

                    });
            }else{
                toastr.warning('Introduzca sus datos');
            }

        };
    }
}
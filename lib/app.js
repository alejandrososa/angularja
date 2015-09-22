/**
 * 
 */
'use strict';
angular.module('appJA',
    [
        'ngRoute',
        'ngResource',

        'satellizer',
        'app.core',        
        'app.config',
        'app.rutas',        
        'app.servicios',
        'app.coreoficina',
        'ngMessages',
        'ngAnimate',
        'ngCookies',
        'toastr',
        'ui.bootstrap',
    ]
);

angular.element(document).ready(function () {
    angular.bootstrap(document, ['appJA']);
});
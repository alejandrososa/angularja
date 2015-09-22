/**
 * 
 */
'use strict';
angular.module('appJA',
    [
        'ngRoute',
        'ngResource',
        // TODO 'ui.bootstrap',
        'satellizer',
        'app.core',
        'app.config',
        'app.rutas',        
        'app.servicios',
        'ngMessages',
        'ngAnimate',
        'ngCookies',
        'toastr',
    ]
);

angular.element(document).ready(function () {
    angular.bootstrap(document, ['appJA']);
});
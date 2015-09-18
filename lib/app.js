/**
 * 
 */
'use strict';
angular.module('appJA',
    [
        'ngRoute',
        'ngResource',
        'ngMessages',
        'ngAnimate',
        'toastr',
        'satellizer',
        'app.rutas',
        'app.core',
        'app.servicios',
        'app.config',
    ]
);

angular.element(document).ready(function () {
    angular.bootstrap(document, ['appJA']);
});
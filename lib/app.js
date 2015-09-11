/**
 * 
 */
'use strict';
angular.module('appJA', [
                       'ngRoute', 
                       'ngResource',
                       'app.rutas',
                       'app.core',
                       'app.servicios', 
                       'app.config'
                       ]
);

angular.element(document).ready(function () {
    angular.bootstrap(document, ['appJA']);
});
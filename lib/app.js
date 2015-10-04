/**
 * 
 */
'use strict';
angular.module('appJA',
    [
        'ngRoute',
        'ngResource',
        'ngMaterial',
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
        'angularMoment'

    ]
)
// create a constant for languages so they can be added to both triangular & translate
    .constant('APP_LANGUAGES', [{
        name: 'LANGUAGES.CHINESE',
        key: 'zh'
    },{
        name: 'LANGUAGES.ENGLISH',
        key: 'en'
    },{
        name: 'LANGUAGES.FRENCH',
        key: 'fr'
    },{
        name: 'LANGUAGES.PORTUGUESE',
        key: 'pt'
    }]);


angular.element(document).ready(function () {
    angular.bootstrap(document, ['appJA']);
});
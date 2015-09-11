/**
 * 
 */
'use strict';

angular
.module('app.rutas', ['ngRoute', 'ngResource'])
.config(config);

function config ($routeProvider, $locationProvider) {
$routeProvider.
    when('/', {
        templateUrl: 'secciones/portada/portada.tpl.html',
        controller: 'PortadaController as portada'
    })
    .when('/premieres', {
            templateUrl: 'secciones/premieres/premieres.tpl.html',
            controller: 'PremieresController as premieres',
            resolve: {
                shows: function(ShowService) {
                    return ShowService.getPremieres();
                }
            }
        })
        .when('/search', {
            templateUrl: 'sections/search/search.tpl.html',
            controller: 'SearchController as search'
        })
        .when('/search/:query', {
            templateUrl: 'sections/search/search.tpl.html',
            controller: 'SearchController as search'
        })
        .when('/popular', {
            templateUrl: 'sections/popular/popular.tpl.html',
            controller: 'PopularController as popular',
            resolve: {
                shows: function(ShowService) {
                    return ShowService.getPopular();
                }
            }
        })
        .when('/view/:id', {
            templateUrl: 'sections/view/view.tpl.html',
            controller: 'ViewController as view',
            resolve: {
                show: function(ShowService, $route) {
                    return ShowService.get($route.current.params.id);
                }
            }
        })
    .otherwise({
        redirectTo: '/'
    });
	
	//$locationProvider.html5Mode(true);
	$locationProvider.html5Mode({
		  enabled: true,
		  requireBase: false
		});
}
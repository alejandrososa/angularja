/**
 * 
 */
'use strict';

angular.module('app.coreoficina', ['ngMessages','ngMaterial','ngSanitize','angularMoment','textAngular','angularFileUpload', 'ngImgCrop'])
.config(moduleConfig);

/* @ngInject */
function moduleConfig($routeProvider, triMenuProvider) {

    triMenuProvider.addMenu({
        name: 'Escritorio',
        icon: 'zmdi zmdi-home',
        type: 'link',
        route: 'admin',
        priority: 0.0
    });

    //triMenuProvider.addMenu({type: "divider", priority: 1.0});
/*
    triMenuProvider.addMenu({
        name: 'Paginas',
        icon: 'zmdi zmdi-collection-text',
        type: 'link',
        route: 'admin/paginas',
        priority: 1.1
    });
    */

    triMenuProvider.addMenu({
        name: 'Pagina Inicio',
        icon: 'zmdi zmdi-developer-board',
        type: 'link',
        route: 'admin/pagina/inicio',
        priority: 1.0
    });

    triMenuProvider.addMenu({
        name: 'Paginas',
        icon: 'zmdi zmdi-collection-text',
        type: 'dropdown',
        priority: 2.1,
        children: [{
            name: 'Listado',
            type: 'link',
            route: 'admin/paginas',
            params: {
                level: 'Item1-1-1-1'
            }
        },{
            name: 'Crear',
            type: 'link',
            route: 'admin/pagina/crear',
            params: {
                level: 'Item1-1-1-1'
            }
        }]
    });


    //triMenuProvider.addMenu({type: "divider", priority: 2.0});

    triMenuProvider.addMenu({
        name: 'Categorias',
        icon: 'zmdi zmdi-widgets',
        type: 'link',
        route: 'admin/categorias',
        priority: 3.1
    });

    //triMenuProvider.addMenu({type: "divider", priority: 3.0});

    triMenuProvider.addMenu({
        name: 'Usuarios',
        icon: 'zmdi zmdi-accounts',
        type: 'link',
        route: 'admin/usuarios',
        priority: 4.1
    });

    //triMenuProvider.addMenu({type: "divider", priority: 4.0});

    triMenuProvider.addMenu({
        name: 'Menu',
        icon: 'fa fa-th-list',
        type: 'link',
        route: 'admin/menu',
        priority: 5.1
    });

    //triMenuProvider.addMenu({type: "divider", priority: 90});

    triMenuProvider.addMenu({
        name: 'Salir',
        icon: 'fa fa-sign-out',
        type: 'link',
        route: 'logout',
        priority: 90.1
    });




    /*
    triMenuProvider.addMenu({
        name: 'MENU.MENU.MENU',
        icon: 'zmdi zmdi-account-add',
        type: 'dropdown',
        priority: 6.1,
        children: [{
            name: 'MENU.MENU.DYNAMIC',
            type: 'link',
            route: 'triangular.admin-default.menu-dynamic'
        },{
            name: 'MENU.MENU.1-1',
            type: 'dropdown',
            children: [{
                name: 'MENU.MENU.2-1',
                type: 'dropdown',
                children: [{
                    name: 'MENU.MENU.3-1',
                    type: 'dropdown',
                    children: [{
                        name: 'MENU.MENU.4-1',
                        type: 'link',
                        route: 'triangular.admin-default.menu-levels',
                        params: {
                            level: 'Item1-1-1-1'
                        }
                    },{
                        name: 'MENU.MENU.4-2',
                        type: 'link',
                        route: 'triangular.admin-default.menu-levels',
                        params: {
                            level: 'Item1-1-1-2'
                        }
                    },{
                        name: 'MENU.MENU.4-3',
                        type: 'link',
                        route: 'triangular.admin-default.menu-levels',
                        params: {
                            level: 'Item1-1-1-3'
                        }
                    }]
                }]
            }]
        }]
    });
    */
}

/*
.run(["$templateCache", function(a) {
    a.put("src/templates/chasingDotsSpinner.html", '<div class="chasing-dots-spinner">\n  <div class="dot1"></div>\n  <div class="dot2"></div>\n</div>\n'), 
    a.put("src/templates/circleSpinner.html", '<div class="spinning-dots-spinner">\n  <div class="spinner-container container1">\n    <div class="circle1"></div>\n    <div class="circle2"></div>\n    <div class="circle3"></div>\n    <div class="circle4"></div>\n  </div>\n  <div class="spinner-container container2">\n    <div class="circle1"></div>\n    <div class="circle2"></div>\n    <div class="circle3"></div>\n    <div class="circle4"></div>\n  </div>\n  <div class="spinner-container container3">\n    <div class="circle1"></div>\n    <div class="circle2"></div>\n    <div class="circle3"></div>\n    <div class="circle4"></div>\n  </div>\n</div>\n'), 
    a.put("src/templates/cubeGridSpinner.html", '<div class="cube-grid-spinner">\n  <div class="cube"></div>\n  <div class="cube"></div>\n  <div class="cube"></div>\n  <div class="cube"></div>\n  <div class="cube"></div>\n  <div class="cube"></div>\n  <div class="cube"></div>\n  <div class="cube"></div>\n  <div class="cube"></div>\n</div>'), 
    a.put("src/templates/doubleBounceSpinner.html", '<div class="double-bounce-spinner">\n  <div class="double-bounce1"></div>\n  <div class="double-bounce2"></div>\n</div>\n'), 
    a.put("src/templates/fadingCircleSpinner.html", '<div class="fading-circle-spinner">\n  <div class="fading-circle1 fading-circle"></div>\n  <div class="fading-circle2 fading-circle"></div>\n  <div class="fading-circle3 fading-circle"></div>\n  <div class="fading-circle4 fading-circle"></div>\n  <div class="fading-circle5 fading-circle"></div>\n  <div class="fading-circle6 fading-circle"></div>\n  <div class="fading-circle7 fading-circle"></div>\n  <div class="fading-circle8 fading-circle"></div>\n  <div class="fading-circle9 fading-circle"></div>\n  <div class="fading-circle10 fading-circle"></div>\n  <div class="fading-circle11 fading-circle"></div>\n  <div class="fading-circle12 fading-circle"></div>\n</div>'), 
    a.put("src/templates/pulseSpinner.html", '<div class="pulse-spinner"></div>\n'), 
    a.put("src/templates/rotatingPlaneSpinner.html", '<div class="three-dots-row-spinner"></div>\n'), 
    a.put("src/templates/threeBounceSpinner.html", '<div class="three-bounce-spinner">\n  <div class="bounce1"></div>\n  <div class="bounce2"></div>\n  <div class="bounce3"></div>\n</div>'), 
    a.put("src/templates/wanderingCubesSpinner.html", '<div class="wandering-cubes-spinner"></div>\n'), 
    a.put("src/templates/waveSpinner.html", '<div class="wave-spinner">\n  <div class="rect1"></div>\n  <div class="rect2"></div>\n  <div class="rect3"></div>\n  <div class="rect4"></div>\n  <div class="rect5"></div>\n</div>\n'), 
    a.put("src/templates/wordPressSpinner.html", '<div class="word-press-spinner">\n  <span class="inner-circle"></span>\n</div>')
}]);*/
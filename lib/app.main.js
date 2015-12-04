/**
 * Created by Alejandro on 22/09/2015.
 */

$.when(
    $.getScript('bower_components/angular/angular.min.js'),
    $.getScript('bower_components/angular/angular-resource.min.js'),
    $.getScript('bower_components/angular/angular-animate.min.js'),
    $.getScript('bower_components/angular/angular-messages.js'),
    $.getScript('bower_components/angular/angular-sanitize.min.js'),
    $.getScript('bower_components/angular/angular-toastr.tpls.js'),
    $.getScript('bower_components/angular/angular-cookies.min.js'),
    $.getScript('bower_components/angular/angular-route.min.js'),
    $.getScript('bower_components/angular/angular-touch.min.js'),
    $.getScript('bower_components/angular/moment.min.js'),
    $.getScript('bower_components/angular/angular-moment.min.js'),
    $.getScript('bower_components/angular/angular-truncate.js'),
    $.getScript('bower_components/angular/angular-preload-image.min.js'),
    $.getScript('bower_components/angular/ui-bootstrap-tpls.min.js'),
    $.getScript('bower_components/bootstrap/dist/js/bootstrap.min.js'),
    $.getScript('bower_components/angular/angular-css.js'),
    $.getScript('bower_components/angular/angular-css.min.js'),
    $.getScript('lib/app.rutas.js'),
    $.getScript('lib/app.config.js'),
    $.getScript('lib/app.core.js'),
    $.getScript('lib/app.coreoficina.js'),
    $.getScript('lib/app.servicios.js'),
    $.getScript('lib/app.satellizer.js'),
    $.getScript('lib/app.js'),
    $.getScript('secciones/portada/portada.ctrl.js'),
    $.getScript('secciones/error/error.ctrl.js'),
    $.getScript('secciones/login/login.ctrl.js'),
    $.getScript('secciones/oficina/admin.ctrl.js'),
    $.getScript('secciones/oficina/master.ctrl.js'),
    $.getScript('servicios/show.fct.js'),
    $.getScript('servicios/page.val.js'),
    $.getScript('servicios/contenido.fct.js'),
    $.getScript('directivas/ngCargando.drct.js'),
    $.getScript('directivas/ngEnter.drct.js'),
    $.getScript('componentes/logo/logo.drct.js'),
    $.getScript('componentes/menutop/menu.drct.js'),
    $.getScript('componentes/menu/menu.drct.js'),
    $.getScript('componentes/menusecundario/menu.drct.js'),
    $.getScript('componentes/menuinferior/menu.drct.js'),
    $.getScript('componentes/slider/slider.drct.js'),
    $.getScript('componentes/etiquetas/etiquetas.drct.js'),
    $.getScript('componentes/articulos/articulos.drct.js'),
    $.getScript('componentes/listadoarticulos/articulos.drct.js'),
    $.getScript('componentes/listadocategorias/categorias.drct.js'),
    $.getScript('componentes/show/show.drct.js'),
    $.getScript('componentes/quienesomos/quienesomos.drct.js'),
    $.getScript('componentes/eventos/eventos.drct.js'),
    $.getScript('componentes/comentarios/comentarios.drct.js'),
    $.getScript('componentes/galeria/galeria.drct.js'),
    $.getScript('componentes/videos/videos.drct.js'),
    $.getScript('componentes/publicidad/publicidad.drct.js'),
    $.getScript('componentes/piedepagina/pie.drct.js'),
    $.getScript('secciones/oficina/html/directivas/menu/menu.drct.js'),
    $.getScript('secciones/oficina/html/directivas/header/header.drct.js'),
    $.Deferred(function( deferred ){
        $( deferred.resolve );
    })
).done(function(){

        console.log('Todos los scripts cargados');
        //place your code here, the scripts are all loaded

    });



// include angular loader, which allows the files to load in any order
//@@NG_LOADER_START@@
// You need to run `npm run update-index-async` to inject the angular async code here
//@@NG_LOADER_END@@

// include a third-party async loader library
/*!
 * $script.js v1.3
 * https://github.com/ded/script.js
 * Copyright: @ded & @fat - Dustin Diaz, Jacob Thornton 2011
 * Follow our software http://twitter.com/dedfat
 * License: MIT
 */
//!function(a,b,c){function t(a,c){var e=b.createElement("script"),f=j;e.onload=e.onerror=e[o]=function(){e[m]&&!/^c|loade/.test(e[m])||f||(e.onload=e[o]=null,f=1,c())},e.async=1,e.src=a,d.insertBefore(e,d.firstChild)}function q(a,b){p(a,function(a){return!b(a)})}var d=b.getElementsByTagName("head")[0],e={},f={},g={},h={},i="string",j=!1,k="push",l="DOMContentLoaded",m="readyState",n="addEventListener",o="onreadystatechange",p=function(a,b){for(var c=0,d=a.length;c<d;++c)if(!b(a[c]))return j;return 1};!b[m]&&b[n]&&(b[n](l,function r(){b.removeEventListener(l,r,j),b[m]="complete"},j),b[m]="loading");var s=function(a,b,d){function o(){if(!--m){e[l]=1,j&&j();for(var a in g)p(a.split("|"),n)&&!q(g[a],n)&&(g[a]=[])}}function n(a){return a.call?a():e[a]}a=a[k]?a:[a];var i=b&&b.call,j=i?b:d,l=i?a.join(""):b,m=a.length;c(function(){q(a,function(a){h[a]?(l&&(f[l]=1),o()):(h[a]=1,l&&(f[l]=1),t(s.path?s.path+a+".js":a,o))})},0);return s};s.get=t,s.ready=function(a,b,c){a=a[k]?a:[a];var d=[];!q(a,function(a){e[a]||d[k](a)})&&p(a,function(a){return e[a]})?b():!function(a){g[a]=g[a]||[],g[a][k](b),c&&c(d)}(a.join("|"));return s};var u=a.$script;s.noConflict=function(){a.$script=u;return this},typeof module!="undefined"&&module.exports?module.exports=s:a.$script=s}(this,document,setTimeout)

// load all of the dependencies asynchronously.
/*
$script([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/angular/angular.min.js',
        'bower_components/angular/angular-resource.min.js',
        'bower_components/angular/angular-animate.min.js',
        'bower_components/angular/angular-messages.js',
        'bower_components/angular/angular-sanitize.min.js',
        'bower_components/angular/angular-toastr.tpls.js',
        'bower_components/angular/angular-cookies.min.js',
        'bower_components/angular/angular-route.min.js',
        'bower_components/angular/angular-touch.min.js',
        'bower_components/angular/moment.min.js',
        'bower_components/angular/angular-moment.min.js',
        'bower_components/angular/angular-truncate.js',
        'bower_components/angular/angular-preload-image.min.js',
        'bower_components/angular/ui-bootstrap-tpls.min.js',
        'bower_components/bootstrap/dist/js/bootstrap.min.js',
        'bower_components/angular/angular-css.js',
        'bower_components/angular/angular-css.min.js',
        'lib/app.rutas.js',
        'lib/app.config.js',
        'lib/app.core.js',
        'lib/app.coreoficina.js',
        'lib/app.servicios.js',
        'lib/app.satellizer.js',
        'lib/app.js',
        'secciones/portada/portada.ctrl.js',
        'secciones/error/error.ctrl.js',
        'secciones/login/login.ctrl.js',
        'secciones/oficina/admin.ctrl.js',
        'secciones/oficina/master.ctrl.js',
        'servicios/show.fct.js',
        'servicios/page.val.js',
        'servicios/contenido.fct.js',
        'directivas/ngCargando.drct.js',
        'directivas/ngEnter.drct.js',
        'componentes/logo/logo.drct.js',
        'componentes/menutop/menu.drct.js',
        'componentes/menu/menu.drct.js',
        'componentes/menusecundario/menu.drct.js',
        'componentes/menuinferior/menu.drct.js',
        'componentes/slider/slider.drct.js',
        'componentes/etiquetas/etiquetas.drct.js',
        'componentes/articulos/articulos.drct.js',
        'componentes/listadoarticulos/articulos.drct.js',
        'componentes/listadocategorias/categorias.drct.js',
        'componentes/show/show.drct.js',
        'componentes/quienesomos/quienesomos.drct.js',
        'componentes/eventos/eventos.drct.js',
        'componentes/comentarios/comentarios.drct.js',
        'componentes/galeria/galeria.drct.js',
        'componentes/videos/videos.drct.js',
        'componentes/publicidad/publicidad.drct.js',
        'componentes/piedepagina/pie.drct.js',
        'secciones/oficina/html/directivas/menu/menu.drct.js',
        'secciones/oficina/html/directivas/header/header.drct.js',

], function() {
    // when all is done, execute bootstrap angular application
    //angular.bootstrap(document, ['myApp']);
});
    */
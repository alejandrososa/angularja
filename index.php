<html>
<head lang="es">
    <base href="/">
    <meta charset="UTF-8">
    <meta name="fragment" content="!" />
    <title></title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap-theme.min.css">
    
</head>
<body>
    
    {{1 + 3}}
    <header id="site-header">
        <div class="container">
            <div class="pull-left logo">ANGULARJS <span class="alt">BY</span> EXAMPLE</div>
            <ul class="pull-right menu">
                <li><a href="/">HOME</a></li>
                <li><a href="/premieres">PREMIERES</a></li>
                <li><a href="/popular">POPULAR</a></li>
                <li><a href="/search">SEARCH</a></li>
            </ul>
        </div>
    </header>

   

    <section id="main">
        <div class="container">
            <ng-view></ng-view>
        </div>
    </section>
    
    <!-- build:assets assets.min.js -->
    <!-- ASSETS -->
        <script src="bower_components/angular/angular.min.js"></script>
        <script src="bower_components/angular/angular-resource.min.js"></script>
        <script src="bower_components/angular/angular-animate.min.js"></script>
        <script src="bower_components/angular/angular-cookies.min.js"></script>
        <script src="bower_components/angular/angular-route.min.js"></script>
        <script src="bower_components/angular/angular-touch.min.js"></script>
        <script src="bower_components/angular/moment.min.js"></script>
        <script src="bower_components/angular/angular-moment.min.js"></script>
        <script src="bower_components/angular/angular-truncate.js"></script>
        <script src="bower_components/angular/angular-preload-image.min.js"></script>
    <!-- / -->
    <!-- endbuild -->
    <!-- build:js app.min.js -->
    <!-- MODULES -->
        <script src="lib/app.rutas.js"></script>
        <script src="lib/app.config.js"></script>
        <script src="lib/app.core.js"></script>
        <script src="lib/app.servicios.js"></script>
        <script src="lib/app.js"></script>
    <!-- / -->
    <!-- CONTROLLERS -->
        <script src="secciones/portada/portada.ctrl.js"></script>
    <!-- / -->
    <!-- SERVICES -->
        <script src="servicios/show.fct.js"></script>
        <script src="servicios/page.val.js"></script>
    <!-- / -->
    <!-- DIRECTIVES -->
        <script src="componentes/show/show.drct.js"></script>
        <script src="directivas/ngEnter.drct.js"></script>
    <!-- / -->
</body>
</html>
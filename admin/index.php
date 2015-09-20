<HTML>
<!-- BEGIN html -->
<html lang = "es">
	<!-- BEGIN head -->
	<head>
	<base href="/">
    <meta charset="UTF-8">
    <meta name="fragment" content="!" />
		<title>JA | Portada</title>

		<!-- Meta Tags -->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/plantillas/solido/images/favicon.ico" type="image/x-icon" />

		<!-- Estilos General -->
		<link type="text/css" rel="stylesheet" href="assets/general/angular-toastr.css" />

		<!-- Stylesheets -->
		<link type="text/css" rel="stylesheet" href="assets/plantillas/admin/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="assets/plantillas/admin/css/main.min.css" />
		<link type="text/css" rel="stylesheet" href="assets/plantillas/admin/css/font-awesome.min.css" />

		<!--[if lte IE 8]>
		<link type="text/css" rel="stylesheet" href="css/ie-ancient.css" />
		<![endif]-->

	<!-- END head -->
	</head>

	<!-- BEGIN body -->
	<body>

    <body ng-controller="MasterController as vm">


    <div id="page-wrapper" ng-show="vista=true" ng-class="{'open': toggle}" ng-cloak>

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar">
                <li class="sidebar-main">
                    <a ng-click="toggleSidebar()">
                        Dashboard
                        <span class="menu-icon glyphicon glyphicon-transfer"></span>
                    </a>
                </li>
                <li class="sidebar-title"><span>NAVIGATION</span></li>
                <li class="sidebar-list">
                    <a href="#">Dashboard <span class="menu-icon fa fa-tachometer"></span></a>
                </li>
                <li class="sidebar-list">
                    <a href="#/tables">Tables <span class="menu-icon fa fa-table"></span></a>
                </li>
                <li class="sidebar-list">
                    <a ng-click="logout()">Salir <span class="menu-icon fa fa-tachometer"></span></a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <div class="col-xs-4">
                    <a href="https://github.com/rdash/rdash-angular" target="_blank">
                        Github
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="https://github.com/rdash/rdash-angular/README.md" target="_blank">
                        About
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="#">
                        Support
                    </a>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <div id="content-wrapper">
            <div class="page-content">

                <!-- Header Bar -->
                <div class="row header">
                    <div class="col-xs-12">
                        <div class="user pull-right">
                            <div class="item dropdown">
                                <a href="#" class="dropdown-toggle">
                                    <img src="img/avatar.jpg">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-header">
                                        Joe Bloggs
                                    </li>
                                    <li class="divider"></li>
                                    <li class="link">
                                        <a href="#">
                                            Profile
                                        </a>
                                    </li>
                                    <li class="link">
                                        <a href="#">
                                            Menu Item
                                        </a>
                                    </li>
                                    <li class="link">
                                        <a href="#">
                                            Menu Item
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li class="link">
                                        <a href="#">
                                            Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="item dropdown">
                                <a href="#" class="dropdown-toggle">
                                    <i class="fa fa-bell-o"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-header">
                                        Notifications
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#">Server Down!</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="meta">
                            <div class="page">
                                Dashboard
                            </div>
                            <div class="breadcrumb-links">
                                Home / Dashboard
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Header Bar -->

                <!-- Main Content -->
                <div ui-view></div>

            </div><!-- End Page Content -->
        </div><!-- End Content Wrapper -->
    </div><!-- End Page Wrapper -->



	<!-- build:assets assets.min.js -->
	    <!-- ASSETS -->
            <script src="../bower_components/jquery/dist/jquery.js"></script>
	        <script src="../bower_components/angular/angular.min.js"></script>
	        <script src="../bower_components/angular/angular-resource.min.js"></script>
	        <script src="../bower_components/angular/angular-animate.min.js"></script>
			<script src="../bower_components/angular/angular-messages.js"></script>
			<script src="../bower_components/angular/angular-sanitize.min.js"></script>
			<script src="../bower_components/angular/angular-toastr.tpls.js"></script>
	        <script src="../bower_components/angular/angular-cookies.min.js"></script>
	        <script src="../bower_components/angular/angular-route.min.js"></script>
	        <script src="../bower_components/angular/angular-touch.min.js"></script>
	        <script src="../bower_components/angular/moment.min.js"></script>
	        <script src="../bower_components/angular/angular-moment.min.js"></script>
	        <script src="../bower_components/angular/angular-truncate.js"></script>
	        <script src="../bower_components/angular/angular-preload-image.min.js"></script>
			<script src="../bower_components/angular/ui-bootstrap-tpls.min.js"></script>
            <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- endbuild -->
	    <!-- build:js app.min.js -->
	    <!-- MODULES -->
	        <script src="lib/app.rutas.js"></script>
	        <script src="lib/app.config.js"></script>
	        <script src="lib/app.core.js"></script>
	        <script src="lib/app.servicios.js"></script>
			<script src="lib/app.satellizer.js"></script>
	        <script src="lib/app.js"></script>
	    <!-- / -->
	    <!-- CONTROLLERS -->
	        <script src="secciones/portada/portada.ctrl.js"></script>
			<script src="secciones/error/error.ctrl.js"></script>
			<script src="secciones/login/login.ctrl.js"></script>
            <script src="secciones/login/logout.ctrl.js"></script>
            <script src="secciones/oficina/master.ctrl.js"></script>
			<script src="secciones/oficina/admin.ctrl.js"></script>
	    <!-- / -->
	    <!-- SERVICES -->
	        <script src="servicios/show.fct.js"></script>
	        <script src="servicios/page.val.js"></script>
	        <script src="servicios/contenido.fct.js"></script>
	    <!-- / -->
	    <!-- DIRECTIVES -->
	    	<script src="componentes/logo/logo.drct.js"></script>
	    	<script src="componentes/menutop/menu.drct.js"></script>	    	
	    	<script src="componentes/menu/menu.drct.js"></script>
	    	<script src="componentes/menusecundario/menu.drct.js"></script>
	    	<script src="componentes/menuinferior/menu.drct.js"></script>	 	    	
	    	<script src="componentes/slider/slider.drct.js"></script>
	    	<script src="componentes/etiquetas/etiquetas.drct.js"></script>	    	
	    	<script src="componentes/articulos/articulos.drct.js"></script>	    	
	    	<script src="componentes/listadoarticulos/articulos.drct.js"></script>
	    	<script src="componentes/listadocategorias/categorias.drct.js"></script>
	        <script src="componentes/show/show.drct.js"></script>
	        <script src="directivas/ngEnter.drct.js"></script>
	        <script src="componentes/quienesomos/quienesomos.drct.js"></script>
	        <script src="componentes/eventos/eventos.drct.js"></script>
	        <script src="componentes/comentarios/comentarios.drct.js"></script>
	        <script src="componentes/galeria/galeria.drct.js"></script>
	        <script src="componentes/videos/videos.drct.js"></script>	        
	        <script src="componentes/publicidad/publicidad.drct.js"></script>
	        <script src="componentes/piedepagina/pie.drct.js"></script>
	    <!-- / -->
		
		
		
		
		
		
		
		
		


	<!-- END body -->
	</body>
<!-- END html -->
</html>
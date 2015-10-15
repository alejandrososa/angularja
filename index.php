<HTML>
<!-- BEGIN html -->
<html lang = "es">
	<!-- BEGIN head -->
	<head>
	<base href="/">
    <meta charset="UTF-8">
    <meta name="fragment" content="!" />
		<title>JA | Oficina</title>

		<!-- Meta Tags -->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

		<!-- Favicon -->
		<link rel="shortcut icon" href="assets/plantillas/solido/images/favicon.ico" type="image/x-icon" />

		<!-- Estilos General

		-->
		<link type="text/css" rel="stylesheet" href="assets/general/general.css" />
		<link type="text/css" rel="stylesheet" href="assets/general/angular-toastr.css" />
		<link type="text/css" rel="stylesheet" href="assets/general/angular-spinkit.min.css" />


		<link type="text/css" rel="stylesheet" href="assets/plantillas/admin/css/admin.css" />
		<!--<link type="text/css" href="https://material.angularjs.org/HEAD/angular-material.css" />-->

		<!-- Stylesheets
		<link type="text/css" rel="stylesheet" href="assets/plantillas/solido/css/reset.css" />
		<link type="text/css" rel="stylesheet" href="assets/plantillas/solido/css/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="assets/plantillas/solido/css/main-stylesheet.css" />
		<!-- For white edition style
		<link type="text/css" rel="stylesheet" href="assets/plantillas/solido/css/white-edition.css" />
		<link type="text/css" rel="stylesheet" href="assets/plantillas/solido/css/lightbox.css" />
		<link type="text/css" rel="stylesheet" href="assets/plantillas/solido/css/shortcodes.css" />
		<link type="text/css" rel="stylesheet" href="assets/plantillas/solido/css/custom-fonts.css" />
		<link type="text/css" rel="stylesheet" href="assets/plantillas/solido/css/custom-colors.css" />
		<link type="text/css" rel="stylesheet" href="assets/plantillas/solido/css/owl.carousel.css" />
		<link type="text/css" rel="stylesheet" href="assets/plantillas/solido/css/responsive.css" />
		<link type="text/css" rel="stylesheet" href="assets/plantillas/solido/css/animate.css" />
		<link type="text/css" rel="stylesheet" href="assets/plantillas/solido/css/dat-menu.css" />-->

        <!--[if lte IE 8]>
		<link type="text/css" rel="stylesheet" href="css/ie-ancient.css" />
		<![endif]-->


        <style>
            [ng-cloak] {
                display: none;
            }
        </style>

	<!-- END head -->
	</head>

	<!-- BEGIN body s-->
	<body ng-cloak>


		<!--<ng-Cargando></ng-Cargando>-->
		<!--<div raw-ajax-busy-indicator="" class="ajax-busy-indicator"></div>-->

		<ng-view></ng-view>



		
		
		<!-- build:assets assets.min.js -->
	    <!-- ASSETS -->
            <script src="bower_components/jquery/dist/jquery.js"></script>
	        <script src="bower_components/angular/angular.min.js"></script>
			<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
			<script src="bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
			<script src="bower_components/angular/angular-resource.min.js"></script>
	        <script src="bower_components/angular-animate/angular-animate.min.js"></script>
			<script src="bower_components/angular/angular-messages.js"></script>
			<script src="bower_components/angular/angular-sanitize.min.js"></script>
			<script src="bower_components/angular-toastr/angular-toastr.tpls.js"></script>
	        <script src="bower_components/angular/angular-cookies.min.js"></script>
	        <script src="bower_components/angular/angular-route.min.js"></script>
	        <script src="bower_components/angular/angular-touch.min.js"></script>
	        <script src="bower_components/moment/moment.js"></script>
	        <script src="bower_components/angular-moment/angular-moment.min.js"></script>
	        <script src="bower_components/angular-truncate/angular-truncate.js"></script>
	        <script src="bower_components/angular-preload/angular-preload-image.min.js"></script>
			<script src="bower_components/angular-css/angular-css.js"></script>
			<script src="bower_components/angular-css/angular-css.min.js"></script>
			<script src="bower_components/ng-file-upload/ng-file-upload.js"></script>
			<script src="bower_components/angular-animate/angular-animate.min.js"></script>
			<script src="bower_components/angular-aria/angular-aria.min.js"></script>
			<script src="bower_components/angular-material/angular-material.min.js"></script>
	    <!-- / -->
	    <!-- endbuild -->
	    <!-- build:js app.min.js -->
	    <!-- MODULES -->
	        <script src="lib/app.rutas.js"></script>
	        <script src="lib/app.config.js"></script>
	        <script src="lib/app.core.js"></script>
			<script src="lib/app.coreoficina.js"></script>
	        <script src="lib/app.servicios.js"></script>
			<script src="lib/app.satellizer.js"></script>
	        <script src="lib/app.js"></script>
	    <!-- / -->
	    <!-- CONTROLLERS -->
	        <script src="secciones/portada/portada.ctrl.js"></script>
			<script src="secciones/error/error.ctrl.js"></script>
			<script src="secciones/login/login.ctrl.js"></script>
			<script src="secciones/oficina/admin.ctrl.js"></script>
            <script src="secciones/oficina/master.ctrl.js"></script>
			<script src="secciones/oficina/usuarios/usuarios.ctrl.js"></script>
			<script src="secciones/oficina/categorias/categorias.ctrl.js"></script>
			<script src="secciones/oficina/paginas/paginas.ctrl.js"></script>
			<script src="secciones/oficina/menu/menu.ctrl.js"></script>
	    <!-- / -->
	    <!-- SERVICES -->
	        <script src="servicios/show.fct.js"></script>
	        <script src="servicios/page.val.js"></script>
	        <script src="servicios/contenido.fct.js"></script>
			<script src="servicios/usuarios.fct.js"></script>
			<script src="servicios/categorias.fct.js"></script>
			<script src="servicios/paginas.fct.js"></script>
			<script src="servicios/menu.fct.js"></script>
	    <!-- / -->
	    <!-- DIRECTIVES -->
	    	<script src="directivas/ngCargando.drct.js"></script>
			<script src="directivas/ngEnter.drct.js"></script>
	    	<script src="componentes/logo/logo.drct.js"></script>
	    	<script src="componentes/menu/menu.drct.js"></script>
	    	<script src="componentes/slider/slider.drct.js"></script>
	    	<script src="componentes/etiquetas/etiquetas.drct.js"></script>	    	
	    	<script src="componentes/articulos/articulos.drct.js"></script>	    	
	    	<script src="componentes/listadoarticulos/articulos.drct.js"></script>
	    	<script src="componentes/listadocategorias/categorias.drct.js"></script>
	        <script src="componentes/show/show.drct.js"></script>
	        <script src="componentes/quienesomos/quienesomos.drct.js"></script>
	        <script src="componentes/eventos/eventos.drct.js"></script>
	        <script src="componentes/comentarios/comentarios.drct.js"></script>
	        <script src="componentes/galeria/galeria.drct.js"></script>
	        <script src="componentes/videos/videos.drct.js"></script>	        
	        <script src="componentes/publicidad/publicidad.drct.js"></script>
	        <script src="componentes/piedepagina/pie.drct.js"></script>

		<script src="lib/app.layout.js"></script>
		<script src="lib/layouts.provider.js"></script>
		<script src="lib/theming.provider.js"></script>
		<script src="lib/skins.provider.js"></script>
		<script src="lib/trisettings.provider.js"></script>
		<script src="lib/config.triangular.settings.js"></script>
		<script src="lib/config.triangular.themes.js"></script>

			<script src="secciones/oficina/html/directivas/menu/menu.drct.js"></script>
			<script src="secciones/oficina/html/directivas/header/header.drct.js"></script>
			<script src="secciones/oficina/html/directivas/tabla/tabla.drct.js"></script>
	    <!-- / -->





		<script src="secciones/oficina/html/componentes/toolbars/toolbar.controller.js"></script>

		<script src="secciones/oficina/html/componentes/breadcrumbs/breadcrumbs.service.js"></script>

		<script src="secciones/oficina/html/componentes/menu/menu.directive.js"></script>
		<script src="secciones/oficina/html/componentes/menu/menu-item.directive.js"></script>
		<script src="secciones/oficina/html/componentes/menu/menu.provider.js"></script>


		<script src="componentes/loader/loader.directive.js"></script>
		<script src="componentes/loader/loader-service.js"></script>


		<script src="secciones/oficina/html/componentes/content/content.drct.js"></script>
		<script src="secciones/oficina/html/componentes/footer/footer.drct.js"></script>

		<script src="secciones/oficina/html/directivas/sidebar/sidebar.drct.js"></script>

		<script src="secciones/oficina/html/componentes/login/login.drct.js"></script>

		<script src="secciones/oficina/html/componentes/table/tabla.drct.js"></script>
		<script src="secciones/oficina/html/componentes/table/table-cell-image.filter.js"></script>
		<script src="secciones/oficina/html/componentes/table/table-start-from.filter.js"></script>

		<script src="secciones/oficina/html/directivas/tema-fondo.drct.js"></script>


		
		
		

		<!-- Scripts -->
		<!--<script type="text/javascript" src="assets/plantillas/solido/jscript/jquery-latest.min.js"></script>
		<script type="text/javascript" src="assets/plantillas/solido/jscript/elementQuery.min.js"></script>
		<script type="text/javascript" src="assets/plantillas/solido/jscript/theme-scripts.js"></script>
		<script type="text/javascript" src="assets/plantillas/solido/jscript/lightbox.js"></script>
		<script type="text/javascript" src="assets/plantillas/solido/jscript/iscroll.js"></script>
		<script type="text/javascript" src="assets/plantillas/solido/jscript/modernizr.custom.50878.js"></script>
		<script type="text/javascript" src="assets/plantillas/solido/jscript/dat-menu.js"></script>
		<script type="text/javascript" src="assets/plantillas/solido/jscript/SmoothScroll.min.js"></script>
		<script type="text/javascript" src="assets/plantillas/solido/jscript/owl.carousel.min.js"></script>
		<script>
			jQuery(document).ready(function() {
				jQuery(".ot-slider").owlCarousel({
					items : 1,
					autoplay : true,
					nav : true,
					lazyload : false,
					responsive : true,
					dots : true,
					margin : 15
				});

				jQuery(".big-pic-random .slider-items").owlCarousel({
					items : 1,
					autoplay : false,
					nav : true,
					lazyload : false,
					dots : false,
					margin : 15
				});

				jQuery(".related-articles-inherit").owlCarousel({
					items : 4,
					autoplay : false,
					nav : true,
					lazyload : false,
					dots : true,
					margin : 15,
					responsive:{
						0:{
							items: 1,
							nav: true
						},
						400:{
							items: 2,
							nav: false
						},
						700:{
							items: 4,
							nav: true,
							loop: false
						}
					}
				});
			});
		</script> -->
		<!-- Demo Only 
		<script type="text/javascript" src="assets/plantillas/solido/jscript/demo-settings.js"></script>
		-->
	<!-- END body -->
	</body>
<!-- END html -->
</html>
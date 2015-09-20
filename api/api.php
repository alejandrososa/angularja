<?php
    require_once __DIR__ . '/vendor/autoload.php';
	require_once __DIR__ . '/vendor/jarestful/Entorno.php';
	require_once(ESPACIO.'app_global.php');

	use Api\ServicioJA;

	$api = ServicioJA::getInstance(); // new API;
	$api->iniciarServicio();
?>
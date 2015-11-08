<?php
    require_once __DIR__ . '/vendor/autoload.php';
	require_once __DIR__ . '/vendor/modelo/generated-conf/config.php';

	use Api\ServicioJA;
	use App\Config;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;
	use Propel\Runtime\Propel;
	use Propel\Runtime\ServiceContainer;

	$config = new Config();

	//ver errores app_global
	if($config::$DEBUG){
		$defaultLogger = new Logger($config::$LOG);
		$defaultLogger->pushHandler(new StreamHandler($config::$RUTA_LOGS, Logger::API));
		Propel::getServiceContainer()->setLogger($config::$LOG, $defaultLogger);
	}

	$api = new ServicioJA();
	$api->iniciarServicio();